<?php


namespace App\Http\Controllers;

use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
        $this->middleware('role:ROLE_ADMIN');
    }

    public function index(Request $request){

        $users = array();
        if(isset($request->status)){
            $users = User::where('status', $request->status)->get();
        }else{

            $users = User::all();
        }
        $stats = $this->getStats();

        return view('admin.user.index', compact('users', 'stats'));
    }

    public function updateStatus($id, $status)
    {
        if(User::where('id', $id)->where('is_admin', '0')->count())
        {
            User::where('id', $id)->update([
                "status" => $status
            ]);

            return ['status' => 'success', 'msg' => 'Record has been updated.'];
        }else{
            return ['status' => 'failed', 'msg' => 'User not found.'];
        }
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'unique:users', 'email:rfc'],
            'password' => ['required', 'min:6'],
            'phone' => ['required'],
            'role' => ['required'],
        ]);
        $user = new User();
        $user->email =  $validatedData['email'];
        $user->name = $validatedData['name'];
        $user->password = bcrypt($validatedData['password']);
        $user->phone = $validatedData['phone'];
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();
        $user->save();

        $role = $this->addRole($user, $validatedData);
        return redirect(url('/users'))->with('success', 'User has been added.');
    }

    public function addRole($user, $request)
    {
        return \DB::table('role_user')->insert([
            "role_id" => $request['role'],
            "user_id" => $user->id,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now()
        ]);
    }
    public function getStats(){

        // return [
        //     "totalUsers" => User::where('is_admin', '0')->count(),
        //     "active" => User::where('is_admin', '0')->where('status', 'Active')->count(),
        //     "nonActive" => User::where('is_admin', '0')->where('status', 'Inactive')->count()
        // ];
        return [
            "totalUsers" => User::count(),
            "active" => User::where('status', 'Active')->count(),
            "nonActive" => User::where('status', 'Inactive')->count()
        ];
    }

	public function edit($id) {
		$user = User::where(DB::raw('MD5(id)'), $id)->first();
		
		if (!$user) {
			return redirect(url('/users'))->with('error', 'User Not found.');
		}
		$user_role = $user->roles()->get();
		if (count($user_role) == 0) {
			return redirect(url('/users'))->with('error', 'User Not found.');
		}

		$roles = Role::all();
		$user_role = $user_role[0];
		
		return view('admin.user.edit', compact('user', 'user_role', 'roles'));
	}

	public function update($id, Request $request) {
		$user = User::where(DB::raw('MD5(id)'), $id)->first();
		
		if (!$user) {
			return redirect(url('/users'))->with('error', 'User Not found.');
		}

		$validatedData = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email:rfc'],
            'phone' => ['required'],
            'role' => ['required'],
        ]);

		
		$check_email = User::where('email', $validatedData['email'])->where('id', '!=', $user->id)->count();
		if ($check_email > 0) {
			return redirect()->back()->with('error', 'Email already exists');
		}

		$user_role = $user->roles()->get();
		if (count($user_role) == 0) {
			return redirect(url('/users'))->with('error', 'User Not found.');
		}

        $user->email =  $validatedData['email'];
        $user->name = $validatedData['name'];
        $user->phone = $validatedData['phone'];
        $user->update();

		// if has different role
		if ($user_role[0]->id != $validatedData['role']) {
			DB::table('role_user')->where('user_id', $user->id)->delete();
			$role = $this->addRole($user, $validatedData);
		}

        return redirect(url('/users'))->with('success', 'User has been updated.');
	}

	public function updatePassword($id, Request $request) {
		$user = User::where(DB::raw('MD5(id)'), $id)->first();
		
		if (!$user) {
			return redirect(url('/users'))->with('error', 'User Not found.');
		}

		$validatedData = $request->validate([
			'password' => ['required', 'min:6'],
			'cpassword' => ['required', 'min:6'],
		]);

		
		if ($validatedData['password'] != $validatedData['cpassword']) {
			return redirect()->back()->with('error', 'Password does not match!');
		}

		$user->password = bcrypt($validatedData['password']);
		
		$user->update();

		return redirect(url('/users'))->with('success', 'User password has been updated.');
	}
}

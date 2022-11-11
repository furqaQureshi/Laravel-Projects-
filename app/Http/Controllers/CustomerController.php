<?php


namespace App\Http\Controllers;


use App\Models\Customer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:web');
		$this->middleware('roles:ROLE_ADMIN|ROLE_AGENT');
	}

	public function index(Request $request){

		$customers = array();
		if(isset($request->status)){
			$customers = Customer::where('status', $request->status)->get();
		}else{
			$customers = Customer::all();
		}

		$stats = $this->getStats();
		return view('admin.customer.index', compact('customers', 'stats'));
	}

	public function updateStatus($id, $status)
	{
		if(Customer::where('id', $id)->count())
		{
			Customer::where('id', $id)->update([
				"status" => $status
			]);

			return ['status' => 'success', 'msg' => 'Record has been updated.'];
		}else{
			return ['status' => 'failed', 'msg' => 'User not found.'];
		}
	}

	public function create()
	{
		return view('admin.customer.create');
	}

	public function store(Request $request)
	{
		$validatedData = $request->validate([
			'name' => ['required'],
			'email' => ['required', 'unique:users'],
			'password' => ['required', 'min:6'],
			'phone' => ['required'],
			'street' => ['required'],
			'city' => ['required'],
			'state' => ['required'],
			'zip' => ['required'],
			'country' => ['required'],
		]);

		$user = new Customer();
		$user->email =  $validatedData['email'];
		$user->name = $validatedData['name'];
		$user->password = bcrypt($validatedData['password']);
		$user->phone = $validatedData['phone'];
		$user->street = $validatedData['street'];
		$user->city = $validatedData['city'];
		$user->state = $validatedData['state'];
		$user->zip = $validatedData['zip'];
		$user->country = $validatedData['country'];
		$user->unique_id = Str::random(10);;
		$user->created_at = Carbon::now();
		$user->updated_at = Carbon::now();
		$user->save();

		return redirect(url('/customers'))->with('success', 'Customer has been added.');
	}

	public function getStats(){

		return [
			"totalCustomers" => Customer::count(),
			"active" => Customer::where('status', 'Active')->count(),
			"nonActive" => Customer::where('status', 'Inactive')->count()
		];
	}

	public function edit($id) {
		$customer = Customer::where(DB::raw('MD5(id)'), $id)->first();
		
		if (!$customer) {
			return redirect(url('/customers'))->with('error', 'Customer Not found.');
		}

		return view('admin.customer.edit', compact('customer'));
	}

	public function update($id, Request $request) {
		$customer = Customer::where(DB::raw('MD5(id)'), $id)->first();

		if (!$customer) {
			return redirect(url('/customers'))->with('error', 'Customer Not found.');
		}

		$validatedData = $request->validate([
			'name' => ['required'],
			'email' => ['required', 'email:rfc'],
			// 'password' => ['required'],
			'phone' => ['required'],
			'street' => ['required'],
			'city' => ['required'],
			'state' => ['required'],
			'zip' => ['required'],
			'country' => ['required'],
		]);

		$check_email = Customer::where('email', $validatedData['email'])->where('id', '!=', $customer->id)->count();
		if ($check_email > 0) {
			return redirect()->back()->with('error', 'Email already exists');
		}

		$customer->email =  $validatedData['email'];
		$customer->name = $validatedData['name'];
		$customer->phone = $validatedData['phone'];
		$customer->street = $validatedData['street'];
		$customer->city = $validatedData['city'];
		$customer->state = $validatedData['state'];
		$customer->zip = $validatedData['zip'];
		$customer->country = $validatedData['country'];
		
		$customer->update();

		return redirect(url('/customers'))->with('success', 'Customer has been updated.');
	}

	public function updatePassword($id, Request $request) {
		$customer = Customer::where(DB::raw('MD5(id)'), $id)->first();
		$validatedData = $request->validate([
			'password' => ['required', 'min:6'],
			'cpassword' => ['required', 'min:6'],
		]);

		
		if ($validatedData['password'] != $validatedData['cpassword']) {
			return redirect()->back()->with('error', 'Password does not match!');
		}

		$customer->password = bcrypt($validatedData['password']);
		
		$customer->update();

		return redirect(url('/customers'))->with('success', 'Customer password has been updated.');
	}
}

<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Disclaimer;

class DisclaimerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
        $this->middleware('role:ROLE_ADMIN');
    }

    public function index()
    {
        $disclaimers = Disclaimer::all();
        return view('admin.disclaimer.index', compact('disclaimers'));
    }

    public function create(){
        return view('admin.disclaimer.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'detail' => 'required',
            'status' => 'required'
        ]);

        $disclaimer = new Disclaimer();
        $disclaimer->detail = $request->detail;
        $disclaimer->status = $request->status;
        $disclaimer->save();

        if($request->status == "Active"){
            Disclaimer::where('id', '!=', $disclaimer->id)->update([
                "status" => "Inactive"
            ]);
        }

        return redirect()->back()->with('success', 'Record has been added');
    }

    public function edit($id)
    {
        $disclaimer = Disclaimer::where('id', $id)->first();

        return view('admin.disclaimer.update', compact('disclaimer'));
    }

    public function update($id, Request $request)
    {
        if(Disclaimer::where('id', $id)->count()){
            $validatedData = $request->validate([
                'detail' => 'required',
                'status' => 'required'
            ]);

            $disclaimer = Disclaimer::where('id', $id)->first();
            $disclaimer->detail = $validatedData['detail'];
            $disclaimer->status = $validatedData['status'];
            $disclaimer->save();

            if($validatedData['status'] == "Active"){
                Disclaimer::where('id', '!=', $id)->update([
                    "status" => "Inactive"
                ]);
            }

            return redirect('/disclaimers')->with('success', 'Record has been updated');

        }else{
            return redirect()->back()->with('error', 'Something went Wrong, try again later');
        }
    }

    public function updateStatus($id, $status)
    {
        if(Disclaimer::where('id', $id)->count()){
            Disclaimer::where('id', '!=', $id)->update([
                "status" => "Inactive"
            ]);
            Disclaimer::where('id', $id)->update([
                "status" => "Active"
            ]);

            return redirect('/disclaimers')->with('success', 'Record has been updated.');
        }else{
            return redirect()->back()->with('failed', 'Record not found.');
        }
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

//    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
//    protected $redirectTo = RouteServiceProvider::HOME;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $credentials = $request->except(['_token']);
        if (Auth::guard('web')->attempt($credentials)) {

            if(Auth::guard('web')->user()->status == "ACTIVE"){
                return redirect()->intended('dashboard');
            }else{
                Auth::guard('web')->logout();
                return redirect('/login')->with('error', 'Account is Inactive.');
            }
        }else{
            return redirect('/login')->with('error', 'Invalid Email and password');
        }
    }



    public function showLoginForm(){
        return view('auth.login');
    }

    public function logout(Request $request) {
        Auth::guard('web')->logout();
        return redirect('/login');
    }
}

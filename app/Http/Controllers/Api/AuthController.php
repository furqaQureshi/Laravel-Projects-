<?php


namespace App\Http\Controllers\Api;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;
use JWTAuth;

use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    protected function guard()
    {
        return Auth::guard('api');
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($token = auth('api')->attempt($validator->validated())) {

            if(Auth::user()->status == "ACTIVE"){
                return $this->createNewToken($token);
            }else{
                auth()->logout();
                return response()->json(['error' => 'User is Inactive.'], 401);
            }
        }else{
            return response()->json(['error' => 'Email and password is invalid.'], 401);
        }

    }
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {

        return response()->json(auth()->user()->find(Auth::id())->makeVisible(['email', 'phone', 'city', 'zip', 'street', 'state', 'country']));
    }

    /**
     * Update the authenticated User Profile.
     *
     * @return status
     */
    public function updateUserProfile(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'street' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'city' => 'required',
            'country' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = Customer::where('id', Auth::id())->first();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->street = $request->street;
        $user->state = $request->state;
        $user->zip = $request->zip;
        $user->city = $request->city;
        $user->country = $request->country;
        $user->save();

        return ['status' => 'success', 'msg' => 'Record has been updated.'];
    }

    public function updateUserDisclaimer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'is_disclaimer_agree' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = Customer::where('id', Auth::id())->first();
        $user->is_disclaimer_agree = $request->is_disclaimer_agree;
        $user->disclaimer_agree_time = Carbon::now();
        $user->disclaimer_agree_ip = $request->ip();
        $user->save();

        return ['status' => 'success', 'msg' => 'Record has been updated.'];
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = Customer::where('id', Auth::id())->first();
        $user->password = bcrypt($request->password);
        $user->save();

        return ['status' => 'success', 'msg' => 'Record has been updated.'];

    }

    public function addDeviceId(Request $request)
    {
        if($request->device_id || $request->device_type){
            Customer::where('id', Auth::id())->update([
                "device_token" => $request->device_id,
                "device_type" => $request->device_type
            ]);

            return ['status' => 'success', 'msg' => 'Record has been updated'];
        }else{
            return ['status' => 'failed', 'msg' => 'Device id and Device type is required'];
        }
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}

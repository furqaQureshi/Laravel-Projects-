<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordVerifyRequest;
use App\Mail\ForgotPassword;
use App\Models\Customer;
use App\Models\ForgotPasswordRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Claims\Custom;

class UserController extends Controller
{
    /**
     * send the forgot password token.
     *
     * @param  string $email
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgotPassword(Request $request)
    {
        if(Customer::where('email', $request->email)->count()){
            $user = Customer::where('email', $request->email)->first();
            $code = rand(1111,9999);

            // remove all old codes
            ForgotPasswordRequest::where('user_id', $user->id)->delete();
            // add new code
            ForgotPasswordRequest::insert([
                "user_id" => $user->id,
                "code" => $code,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ]);
            Mail::to($request->email)->send(new ForgotPassword($user, $code));
            return ['status' => 'success', 'msg' => 'Email has been sent'];
        }else{
            return ['status' => 'failed', 'msg' => 'user not found'];
        }
    }

    public function forgotPasswordVerify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|min:6',
            'code' => 'required|min:4',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if(Customer::where('email', $request->email)->count()){

            $user = Customer::where('email', $request->email)->first();
            if(ForgotPasswordRequest::where('user_id', $user->id)
                ->where('code', $request->code)
                ->where('status', 'Active')
                ->count()){

                $user->password = bcrypt($request->password);
                $user->save();
                return ['status' => 'success', 'msg' => 'Password has been updated'];

            }else{
                return ['status' => 'failed', 'msg' => 'Code is not verified, try again later'];
            }
        }else{
            return ['status' => 'failed', 'msg' => 'user not found'];
        }
    }
}

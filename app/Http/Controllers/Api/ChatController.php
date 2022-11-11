<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    /**
     * Create a new ChatController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('api');
    }

    public function index()
    {
        return Chat::with('user')
            ->where('unique_id', Auth::user()->unique_id)
            ->orderBy('created_at','desc')
            ->get();
    }

    public function store(Request $request)
    {
        if($request->text){

            Chat::insert([
                "unique_id" => Auth::user()->unique_id,
                "customer_id" => Auth::id(),
                "text" => $request->text,
                "is_admin" => 0,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ]);

            return ['status' => 'success', 'msg'=> "Record has been updated."];

        }else{
            return ['status' => 'failed', 'msg' => 'Text field is requried.'];
        }
    }
}

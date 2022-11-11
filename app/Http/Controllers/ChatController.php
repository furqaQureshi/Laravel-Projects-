<?php


namespace App\Http\Controllers;

use App\Events\RealTimeMessage;
use App\Models\Customer;
use App\Utils\Helper;
use Carbon\Carbon;
// use http\Client\Curl\User;
use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use PHPUnit\TextUI\Help;

class ChatController extends Controller
{
	public function index(Request $request){

		if(Chat::count()){
			$uniqueIds = Chat::pluck('unique_id')->toArray();
			$uniqueIds = array_unique($uniqueIds);
			$idRecord = [];

			foreach($uniqueIds as $id)
			{
				$customer = Customer::where('unique_id', $id)->first();
				array_push($idRecord, [
					"unique_id" => $id,
					"name" => $customer->name
				]);
			}

			if($request->id){
				$activeId = $request->id;
				$admin = User::where('id', Auth::guard('web')->id())->first();
				
				// read chats
				Chat::where('unique_id', $activeId)->where('seen', 0)->where('user_id', null)->update([
					'seen' => 1
				]);

				return view('admin.chat.index', compact('idRecord', 'activeId', 'admin'));

			}else{
				return redirect('/chats?id='.$idRecord[0]['unique_id']);
			}

		}else{
			return view('admin.chat.no-chats');
		}
	}


	public function getChatRecords($id)
	{
		if(Chat::where('unique_id', $id)->count()){
			// fetch record
			$records = Chat::with('user')->where('unique_id', $id)->orderBy('created_at','asc')->get();

			return ['status' => 'success', 'isFound' => 1, 'record' => $records];
		}else{
			return ['status' => 'success', 'isFound' => 0];
		}
	}

	public function store(Request $request)
	{
		if($request->unique_id && $request->text && Chat::where('unique_id', $request->unique_id)->count()){

			Chat::insert([
				"unique_id" => $request->unique_id,
				"user_id" => Auth::guard('web')->id(),
				"text" => $request->text,
				"is_admin" => 1,
				"created_at" => Carbon::now(),
				"updated_at" => Carbon::now(),
			]);

			$this->sendNotificationToDevice($request->unique_id);

			return ['status' => 'success', 'msg' => 'Record has been added.'];
		}else{
			return ['status' => 'failed', 'msg' => 'Something went wrong, try again later'];
		}
	}

	public function sendNotificationToDevice($id)
	{
		//get customer record
		$customer = Customer::where('unique_id', $id)->first();
		if(!empty($customer)){

			if($customer->device_token){
				Helper::sendPushNotification($customer);
			}else{
				Helper::insertLogs('Device Id Not Found', 'Customer: '.$customer->name." Device id not found");
			}
		}
	}

	public function test()
	{
		event(new RealTimeMessage('Hello World'));
	}

	public function getNewChatNotification() {
		$total = 0;
		$uniqueIds = Chat::pluck('unique_id')->toArray();
		$uniqueIds = array_unique($uniqueIds);
		$data = [];
		
		foreach($uniqueIds as $uniqueId) {
			$count = Chat::where('unique_id', $uniqueId)->where('seen', 0)->where('user_id', null)->count();
			$data[$uniqueId] = $count;
			$total += $count;
		}

		return ['status' => 'success', 'msg' => 'New chat records.', 'data' => [
			'chats' => $data,
			'total' => $total,
		]];
	}
}

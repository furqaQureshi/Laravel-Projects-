<?php
namespace App\Utils;


use App\Models\Logs;
use Carbon\Carbon;


class Helper
{
    public static function sendPushNotification($customer)
    {
        $FcmKey = 'AAAA9VE2A_I:APA91bH3sZPlA5hm_j6mtLNe5QswL-eHznKgSBSOdU7v9GTZUourfS2GeJCrZAd4InX5OW5eFaBhKWfuZ_nFVhQReP5E1tK7nZSKx-4JBj8tSIsW8Bvg0QkzsCdJKRAqGilc-LBjFu6M';
        $url = 'https://fcm.googleapis.com/fcm/send';
        $data = [
            "to" => $customer->device_token,
            "notification" => [
                "title" => "New Message",
                "body" => "",
            ]
        ];

        $RESPONSE = json_encode($data);
        $headers = [
            'Authorization:key=' . $FcmKey,
            'Content-Type: application/json',
        ];
        // CURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $RESPONSE);

        $output = curl_exec($ch);
        if ($output === FALSE) {
            die('Curl error: ' . curl_error($ch));
        }
        curl_close($ch);

        Self::insertLogs("Send Push Notification to ".$customer->id."(".$customer->name.")", $output);
    }

    public static function insertLogs($title, $detail)
    {

        Logs::insert([
            "title" => $title,
            "detail" => $detail,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now()
        ]);
    }
}

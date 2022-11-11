<?php

namespace Database\Seeders;

use App\Models\Chat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::where('is_admin', '0')->get();

        foreach($users as $user){
            $uniqid = Str::random(10);
            Chat::insert([
                "unique_id" => $uniqid,
                "user_id" => $user->id,
                "text" => "This is some question",
                "seen" => rand(0, 1),
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ]);


            Chat::insert([
                "unique_id" => $uniqid,
                "user_id" => 1,
                "text" => "This is some Answer",
                "is_admin" => 1,
                "seen" => rand(0, 1),
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ]);
        }
    }
}

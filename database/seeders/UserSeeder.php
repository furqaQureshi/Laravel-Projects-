<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            "name" => "Admin",
            "email" => "admin@oddtechnologies.com",
            "password" => bcrypt("Password@123"),
            "phone" => 982312312,
            "is_admin" => 1,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now()
        ]);
    }
}

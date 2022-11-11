<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserCourse;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        UserCourse::insert([
            "course_id" => 1,
            "user_id" => 2,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now()
        ]);

        UserCourse::insert([
            "course_id" => 1,
            "user_id" => 3,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now()
        ]);
    }
}

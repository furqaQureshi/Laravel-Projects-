<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseReviews;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CourseReviewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CourseReviews::insert([
            "course_id" => 1,
            "user_id" => 2,
            "detail" => "This is some review detail",
            "rating" => rand(1, 5),
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now()
        ]);


        CourseReviews::insert([
            "course_id" => 1,
            "user_id" => 3,
            "detail" => "This is some review detail",
            "rating" => rand(1, 5),
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now()
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseQA;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CourseQASeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $course = Course::where('id', 1)->first();

        $detail = array(
            "Hello, i have a question regarding something",
            "hi, is this course is valid for trading",
            "i wanted to learn pi graph",
            "this is now working out, how i can make it work?",
            "i have a question, please you please contact me ?",
            "Hello, i have a question regarding something",
            "hi, is this course is valid for trading",
            "i wanted to learn pi graph",
            "this is now working out, how i can make it work?",
            "i have a question, please you please contact me ?"
        );
        foreach(range(1, 9) as $index)
        {
            $userId = 2;
            if($index < 6){
                $userId = 3;
            }
            CourseQA::insert([
                "course_id" => $course->id,
                "user_id" => $userId,
                "detail" => $detail[$index],
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ]);
        }
    }
}

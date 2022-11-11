<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseModule;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $course = new Course();
        $course->title = "Binary Options for Beginners";
        $course->save();

        $videoURLPath = "https://moneyxperts.oddtechnologies.com/videos";
        foreach(range(1, 9) as $index){
            CourseModule::insert([
                "course_id" => $course->id,
                "title" => "Module ".$index,
                "url" => $videoURLPath . ($index == 1 ? "/Introduction.mp4": "/Segment ".($index - 1).".mp4"),
                "order" => $index,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ]);
        }


    }
}

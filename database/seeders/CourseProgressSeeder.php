<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseModule;
use App\Models\CourseModuleProgress;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CourseProgressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courseModule = CourseModule::all();

        foreach($courseModule as $module)
        {
            CourseModuleProgress::insert([
                "user_id" => 2,
                "course_id" => 1,
                "module_id" => $module->id,
                "progress" => rand(70, 100),
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ]);

            CourseModuleProgress::insert([
                "user_id" => 3,
                "course_id" => 1,
                "module_id" => $module->id,
                "progress" => rand(80, 100),
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ]);
        }
    }
}

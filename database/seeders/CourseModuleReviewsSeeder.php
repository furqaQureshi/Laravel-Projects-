<?php

namespace Database\Seeders;

use App\Models\CourseModule;
use App\Models\CourseModuleReviews;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CourseModuleReviewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modules = CourseModule::all();
        foreach($modules as $module){
            CourseModuleReviews::insert([
                "course_id" => 1,
                "user_id" => 2,
                "module_id" => $module->id,
                "detail" => "This is some reviews",
                "rating" => rand(1, 5),
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ]);

            CourseModuleReviews::insert([
                "course_id" => 1,
                "user_id" => 3,
                "module_id" => $module->id,
                "detail" => "This is some reviews",
                "rating" => rand(1, 5),
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ]);
        }
    }
}

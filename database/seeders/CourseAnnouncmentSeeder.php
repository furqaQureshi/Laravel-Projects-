<?php

namespace Database\Seeders;

use App\Models\CourseAnnouncment;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CourseAnnouncmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $announc = [
            "Hello this is some announcment",
            "hi, nwe module has been added in this course",
            "hello this is something",
            "Surprise for you, Please check the detail",
            "this is something else"
        ];

        foreach ($announc as $in)
        {
            CourseAnnouncment::insert([
                "course_id" => 1,
                "title" => $in,
                "detail" => $in,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    protected $toTruncate = ['users', 'courses', 'course_modules', 'course_announcments', 'course_q_a', 'course_reviews',
        'course_module_reviews', 'course_module_progress'];
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        foreach($this->toTruncate as $table) {
            \DB::table($table)->truncate();
        }
        Model::reguard();

//         \App\Models\User::factory(10)->create();
         $this->call([
             UserSeeder::class,
             CourseSeeder::class,
             UserCourseSeeder::class,
             CourseReviewsSeeder::class,
             CourseQASeeder::class,
             CourseAnnouncmentSeeder::class,
             CourseProgressSeeder::class,
             CourseModuleReviewsSeeder::class
         ]);
    }
}

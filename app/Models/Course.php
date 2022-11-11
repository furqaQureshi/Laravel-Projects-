<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    public function modules()
    {
        return $this->hasMany(CourseModule::class, 'course_id');
    }

    public function QA()
    {
        return $this->hasMany(CourseQA::class, 'course_id');
    }

    public function reviews()
    {
        return $this->hasMany(CourseReviews::class, 'course_id');
    }

    public function announcments()
    {
        return $this->hasMany(CourseAnnouncment::class, 'course_id');
    }

    public function enrollments()
    {
        return $this->hasMany(UserCourse::class, 'course_id');
    }
}

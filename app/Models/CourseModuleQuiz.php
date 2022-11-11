<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseModuleQuiz extends Model
{
    use HasFactory;
	public $table = 'course_module_quiz';

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

	public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

	public function module()
    {
        return $this->belongsTo(CourseModule::class, 'module_id');
    }

    public function options() {
        return $this->hasMany(CourseModuleQuizOpts::class, 'quiz_id');
    }
    public function correctOption() {
        return $this->hasOne(CourseModuleQuizOpts::class, 'quiz_id')->ofMany([], function ($query) {
			$query->where('is_correct', '=', 1);
		});
    }
}

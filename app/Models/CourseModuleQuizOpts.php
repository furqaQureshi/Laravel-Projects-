<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseModuleQuizOpts extends Model
{
    use HasFactory;
	public $table = 'course_module_quiz_opts';

    protected $hidden = [
        'is_correct',
        'created_at',
        'updated_at'
    ];

	public function quiz()
    {
        return $this->belongsTo(CourseModuleQuiz::class, 'quiz_id');
    }
}

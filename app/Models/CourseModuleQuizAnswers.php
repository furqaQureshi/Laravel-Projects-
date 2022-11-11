<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseModuleQuizAnswers extends Model
{
    use HasFactory;
	public $table = 'customer_quiz_answers';

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

	public function quiz()
    {
        return $this->belongsTo(CourseModuleQuiz::class, 'quiz_id');
    }

	public function result()
    {
        return $this->belongsTo(CourseModuleQuizResult::class, 'result_id');
    }
}

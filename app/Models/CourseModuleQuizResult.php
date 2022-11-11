<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseModuleQuizResult extends Model
{
    use HasFactory;
	public $table = 'customer_quiz_result';

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

	public function quiz()
    {
        return $this->belongsTo(CourseModuleQuiz::class, 'quiz_id');
    }

	public function answers() {
        return $this->hasMany(CourseModuleQuizAnswers::class, 'result_id');
    }
}

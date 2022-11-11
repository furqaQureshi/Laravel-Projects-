<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseModule extends Model
{
    use HasFactory;
    
    protected $fillable = [ 
        'course_id',
        'title',
        'detail',
        'type',
        'url',
        'order',
        'status',
    ];

    protected $hidden = [
        'type',
        'status',
        'created_at',
        'updated_at'
    ];

    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function moduleReviews()
    {
        return $this->hasMany(CourseModuleReviews::class, 'module_id');
    }

    public function moduleProgress()
    {
        return $this->hasOne(CourseModuleProgress::class, 'module_id')->withDefault([
			'progress' => 0,
		]);
    }

	public function moduleQuiz() {
		return $this->hasMany(CourseModuleQuiz::class, 'module_id');
	}
}

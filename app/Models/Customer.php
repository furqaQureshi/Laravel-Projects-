<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Customer extends Authenticatable implements JWTSubject
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'street',
        'state',
        'country',
        'status',
        'zip',
        'city'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'email',
        'phone',
        'street',
        'state',
        'country',
        'status'
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }

    // relationships starts here
    public function userCourses()
    {
        return $this->hasMany(UserCourse::class, 'user_id');
    }

    public function courseReviews()
    {
        return $this->hasMany(CourseReviews::class, 'user_id');
    }

    public function courseAttachmentReviews()
    {
        return $this->hasMany(CourseAttachmentReviews::class, 'user_id');
    }

    public function courseQ_A()
    {
        return $this->hasMany(CourseQA::class, 'user_id');
    }

    public function chats()
    {
        return $this->hasMany(Chat::class, 'customer_id');
    }
}

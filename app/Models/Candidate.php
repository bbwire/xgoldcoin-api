<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Candidate extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'sex',
        'phone',
        'email',
        'experience',
        'skill_set',
        'current_location',
        'professional_background',
        'preferred_work_location',
        'desired_job_type',
        'desired_employment_type',
        'username',
        'password',
        'status'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EducationDetail extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'candidate_id',
        'institution',
        'education_level',
        'course',
        'specialization',
        'start_year',
        'end_year'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmploymentRecord extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'candidate_id',
        'company_name',
        'designation',
        'is_current_employer',
        'year_from',
        'year_to',
        'notice_time'
    ];
}

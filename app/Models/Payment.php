<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'employer_id',
        'project_id',
        'amount',
        'status'
    ];

    public function employer () {
        return $this->belongsTo(Employer::class);
    }

    public function project () {
        return $this->belongsTo(Project::class);
    }
}

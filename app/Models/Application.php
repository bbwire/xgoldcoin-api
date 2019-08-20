<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'candidate_id',
        'project_id',
        'cover_letter',
        'status',
    ];

    public function candidate () {
        return $this->belongsTo(Candidate::class);
    }

    public function project () {
        return $this->belongsTo(Project::class);
    }
}

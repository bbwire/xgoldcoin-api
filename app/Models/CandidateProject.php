<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CandidateProject extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'candidate_id',
        'title',
        'url',
        'is_current',
        'status'
    ];

    public function candidate () {
        return $this->belongsTo(Candidate::class);
    }
}

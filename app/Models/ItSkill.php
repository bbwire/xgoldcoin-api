<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItSkill extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'candidate_id',
        'software',
        'version',
        'last_used'
    ];

    public function candidate () {
        return $this->belongsTo(Candidate::class);
    }
}

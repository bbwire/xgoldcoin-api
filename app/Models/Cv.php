<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cv extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'candidate_id',
        'title',
        'path'
    ];

    public function candidate () {
        return $this->belongsTo(Candidate::class);
    }
}

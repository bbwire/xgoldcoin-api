<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShortList extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'project_id',
        'candidate_id',
        'stage',
        'status'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Network extends Model
{
    protected $fillable = [
        'leader_id',
        'member_id',
        'direction'
    ];

    public function leader () {
        return $this->belongsTo(Member::class, 'leader_id', 'id');
    }

    public function member () {
        return $this->belongsTo(Member::class);
    }
}

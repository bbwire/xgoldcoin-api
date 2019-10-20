<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BitcoinAccount extends Model
{

    protected $fillable = [
        'member_id',
        'account_id',
        'account_balance',
        'status'
    ];

    public function member () {
        return $this->belongsTo(Member::class);
    }
}

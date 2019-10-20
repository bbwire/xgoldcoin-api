<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BitcoinDirectRewardAccount extends Model
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

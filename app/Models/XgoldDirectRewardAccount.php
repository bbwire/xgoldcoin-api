<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class XgoldDirectRewardAccount extends Model
{
    protected $fillable = [
        'member_id',
        'account_id',
        'account_balance',
        'status'
    ];
}

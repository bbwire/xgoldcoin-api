<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
    	'app_name',
    	'withdraw_charge',
    	'xgold_contribution',
    	'bitcoin_contribution',
    	'direct_commission',
    	'indirect_commission'
    ];
}

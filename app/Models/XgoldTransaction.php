<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class XgoldTransaction extends Model
{
    protected $fillable = [
        'xgold_account_id',
        'transaction_id',
        'transaction_type',
        'amount',
        'status'
    ];

    public function xgold_account () {
        return $this->belongsTo(XgoldAccount::class);
    }
}

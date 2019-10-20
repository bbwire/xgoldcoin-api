<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BitcoinTransaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'bitcoin_account_id',
        'transaction_id',
        'transaction_type',
        'amount',
        'status'
    ];

    public function bitcoin_account () {
        return $this->belongsTo(BitcoinAccount::class);
    }
}

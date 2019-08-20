<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyContact extends Model
{

    protected $fillable = [
        'client_id',
        'country',
        'city',
        'street',
        'telephone1',
        'telephone2',
        'fax_number',
        'mobile_number'
    ];

    public function client () {
        return $this->belongsTo(Client::class);
    }
}

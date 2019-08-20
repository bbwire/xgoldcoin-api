<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyDetail extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'client_id',
        'company_name',
        'contact_person',
        'designation',
        'website_url'
    ];

    public function client () {
        return $this->belongsTo(Client::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'client_id',
        'industry_id',
        'title',
        'contact_person',
        'contact_email',
        'contact_phone',
        'organisation_description',
        'description',
        'application_start_date',
        'application_end_date',
        'status'
    ];

    public function client () {
        return $this->belongsTo(Client::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdentityDocument extends Model
{
    protected $fillable = [
        'user_id', 'title', 'path'
    ];
}

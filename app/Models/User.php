<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'role_id',
        'first_name',
        'last_name',
        'sex',
        'date_of_birth',
        'phone',
        'email',
        'photo',
        'username',
        'password'
    ];

    protected $hidden = [
        'password'
    ];

    public function role () {
        return $this->belongsTo(Role::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'referee_id',
        'first_name',
        'last_name',
        'sex',
        'date_of_birth',
        'email',
        'phone',
        'photo',
        'username',
        'password',
        'verification_token',
        'status'
    ];

    public function referee () {
        return $this->belongsTo(Member::class, 'referee_id', 'id');
    }

    public function getPhotoAttribute($value)
    {
        $file_path = env('UPLOADS_URL');
        if ($value == '') 
        {
            return $file_path.'404.png';
        }
        else
        {
            return $file_path.$value;
        }
    }
}

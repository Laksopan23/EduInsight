<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'user_id',
        'user_id_fk',
        'full_name',
        'gender',
        'date_of_birth',
        'qualification',
        'experience',
        'phone_number',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id_fk');
    }
}

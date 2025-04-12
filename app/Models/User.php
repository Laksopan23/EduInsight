<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'password',
        'date_of_birth',
        'join_date',
        'phone_number',
        'status',
        'role_name',
        'avatar',
        'position',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function teacher()
    {
        return $this->hasOne(Teacher::class, 'user_id_fk');
    }

    public function student()
    {
        return $this->hasOne(Student::class, 'user_id_fk');
    }
}

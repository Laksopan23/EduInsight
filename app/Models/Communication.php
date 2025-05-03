<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Communication extends Model
{
    protected $fillable = ['title', 'message', 'sender', 'schedule_date', 'schedule_time', 'meeting_link', 'note'];

    public function receivers()
    {
        return $this->belongsToMany(User::class, 'communication_user', 'communication_id', 'user_id');
    }
}

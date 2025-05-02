<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Communication extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'message',
        'sender',
        'receiver',
        'meeting_link', // Added for live meeting link
    ];
}

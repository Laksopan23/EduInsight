<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'grade',
        'category',
        'subject',
        'exam_date',
        'exam_time',
        'venue',
    ];
}

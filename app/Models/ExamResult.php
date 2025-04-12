<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    use HasFactory;

    protected $fillable = ['exam_id', 'student_id', 'marks_obtained', 'status'];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'time', 'subject_id', 'user_id'];

    // Un examen pertenece a una asignatura
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // Un examen lo realiza un profesor
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'time', 'subject_id', 'user_id'];

    // Relación con la asignatura
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // Relación con el profesor que creó el examen
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

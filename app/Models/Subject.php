<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(User::class, 'subject_user', 'subject_id', 'user_id')
            ->withPivot('role')  // Para diferenciar si un usuario es alumno o profesor en esta asignatura
            ->withTimestamps();
    }
    // Un profesor sube varios apuntes
    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    // Una asignatura tiene varios exámenes
    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    // Una asignatura tiene varias clases
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}

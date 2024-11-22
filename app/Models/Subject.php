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
            ->withPivot('user_type')  // Para diferenciar si un usuario es alumno o profesor en esta asignatura
            ->withTimestamps();
    }

    // Una asignatura tiene varios alumnos
    public function childStudents()
    {
        return $this->belongsToMany(ChildStudent::class, 'child_student_subject', 'child_student_id', 'subject_id')
            ->withTimestamps();
    }

    // Una asignatura tiene varios instrumentos
    public function instruments()
    {
        return $this->hasMany(Instrument::class);
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

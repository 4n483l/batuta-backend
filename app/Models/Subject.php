<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'level'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'subject_user', 'subject_id', 'user_id')
            ->withPivot('user_type');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_subject', 'student_id', 'subject_id');
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}

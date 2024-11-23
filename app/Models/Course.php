<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['subject_id', 'user_id', 'date', 'hour', 'classroom'];

    // una asignatura tiene varias clases
    public function subjects()
    {
        return $this->belongsTo(Subject::class);
    }

    // un profesor imparte varias clases
    public function teachers()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

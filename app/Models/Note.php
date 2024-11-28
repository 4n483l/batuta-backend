<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'topic', 'content', 'user_id', 'subject_id', 'pdf'];

    // un apunte pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // un apunte pertenece a una asignatura
    public function subjects()
    {
        return $this->belongsTo(Subject::class);
    }

}

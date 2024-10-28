<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'user_id', 'subject_id'];

    // un apunte pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // un apunte pertenece a una asignatura
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

}

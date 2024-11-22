<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instrument extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id', 'child_student_id'];

    public function user()
    {
        return $this->belongsToMany(User::class, 'instrument_user');
    }


    public function student()
    {
        return $this->belongsToMany(ChildStudent::class, 'instrument_child_student');
    }




    protected static function booted()
    {
        static::creating(function ($instrument) {
            // Obtener dinámicamente el ID de la asignatura "Instrumentos"
            $instrument->subject_id = Subject::where('name', 'Instrumento')->value('id');

            if (!$instrument->subject_id) {
                throw new \Exception('La asignatura "Instrumentos" no está definida en la base de datos.');
        }

        // Otra forma de asignar el ID de la asignatura "Instrumentos"
           /*  if (empty($instrument->subject_id)) {
                $instrument->subject_id = 1; // ID predeterminado de la asignatura "Instrumentos"
            } */
        });
    }

}

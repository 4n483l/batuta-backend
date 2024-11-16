<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instrument extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'subject_id'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    protected static function booted()
    {
        static::creating(function ($instrument) {
            // Obtener dinámicamente el ID de la asignatura "Instrumentos"
            $instrument->subject_id = Subject::where('name', 'Instrumentos')->value('id');

            // Lanza una excepción si no existe la asignatura
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

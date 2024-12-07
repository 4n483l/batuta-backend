<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'topic', 'content', 'user_id', 'subject_id', 'instrument_id', 'pdf'];

    // un apunte pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function instrument()
    {
        return $this->belongsTo(Instrument::class);
    }

    // comrpueba que al menos uno de los dos campos esté presente, pero no ambos
    protected static function booted()
    {
        static::creating(function ($note) {

            if (!$note->subject_id && !$note->instrument_id) {
                throw new ValidationException('Debe haber al menos un Subject o un Instrument asociado con el apunte.');
            }

            if ($note->subject_id && $note->instrument_id) {
                throw new ValidationException('No puede haber un apunte relacionado con ambos un Subject y un Instrument.');
            }
        });
    }

}

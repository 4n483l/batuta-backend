<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['subject_id', 'user_id', 'instrument_id', 'date', 'hour', 'classroom'];

    // una asignatura tiene varias clases
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function instrument()
    {
        return $this->belongsTo(Instrument::class);
    }

    // un profesor imparte varias clases
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Comprueba que al menos uno de los dos campos esté presente, pero no ambos
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($course) {
            if (is_null($course->subject_id) && is_null($course->instrument_id)) {
                throw new \Exception('Debe proporcionar al menos un subject_id o un instrument_id.');
            }

            if (!is_null($course->subject_id) && !is_null($course->instrument_id)) {
                throw new \Exception('Solo puede proporcionar subject_id o instrument_id, no ambos.');
            }
        });
    }

}

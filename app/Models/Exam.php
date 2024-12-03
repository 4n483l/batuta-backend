<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'hour', 'classroom', 'subject_id', 'user_id', 'instrument_id'];


    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function instrument()
    {
        return $this->belongsTo(Instrument::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Validar que solo uno de subject_id o instrument_id esté presente
      protected static function boot()
    {
        parent::boot();

        static::saving(function ($exam) {
            if (is_null($exam->subject_id) && is_null($exam->instrument_id)) {
                throw new \Exception("Debe especificar un subject_id o un instrument_id.");
            }
            if (!is_null($exam->subject_id) && !is_null($exam->instrument_id)) {
                throw new \Exception("Solo uno de subject_id o instrument_id debe estar presente.");
            }
        });
    }
}

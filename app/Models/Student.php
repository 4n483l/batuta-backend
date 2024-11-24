<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'lastname',
        'dni',
        'phone',
        'address',
        'city',
        'postal_code',
        'birth_date',
        'email',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'student_subject', 'student_id', 'subject_id');
    }

    public function instruments()
    {
        return $this->belongsToMany(Instrument::class, 'instrument_student','student_id', 'instrument_id');
    }

}

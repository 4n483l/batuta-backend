<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildStudent extends Model
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

    public function child()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'child_student_subject', 'child_student_id', 'subject_id');
    }

    public function instruments()
    {
        return $this->belongsToMany(Instrument::class, 'child_student_id', 'instrument_id');
    }

}

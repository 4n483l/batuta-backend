<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'lastname',
        'dni',
        'email',
        'phone',
        'address',
        'city',
        'postal_code',
        'birth_date',
        'role',
        'user_type',
        'password',
];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function parent()
    {
        return $this->hasMany(ChildStudent::class, 'child_student_id');
    }

    // belongsTo es para muchos a muchos
    // Un profesor enseña muchas asignaturas, y un alumno se matricula en varias asignaturas
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_user', 'user_id', 'subject_id')
            ->withPivot('user_type')  // Almacenar si el usuario es profesor o alumno en la asignatura
            ->withTimestamps();
    }


    // un usuario puede tener varios instrumentos
    public function instruments()
    {
        return $this->belongsToMany(Instrument::class, 'instrument_user')
            ->withPivot('subject_id')  // Si quieres almacenar el subject_id en la tabla pivote
                ->withTimestamps();
}



    // Un profesor sube varios apuntes y los alumnos pueden verlos
    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    // Un profesor crea exámenes para sus asignaturas, y los alumnos pueden ver estos exámenes
    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    // Un profesor imparte varias clases
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function rehearsals()
    {
        return $this->belongsToMany(Rehearsal::class, 'user_rehearsal', 'user_id', 'rehearsal_id')
            ->withPivot('user_type')  // Almacenar si el usuario es profesor o alumno en la asignatura
            ->withTimestamps();
    }

  /*   public function concerts()
    {
        return $this->belongsToMany(Concert::class, 'concert_user', 'user_id', 'concert_id')
            ->withPivot('user_type')
            ->withTimestamps();
    } */
}

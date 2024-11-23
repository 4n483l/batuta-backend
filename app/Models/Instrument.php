<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instrument extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'instrument_user', 'instrument_id', 'user_id');
    }


   /*  public function student()
    {
        return $this->belongsToMany(ChildStudent::class, 'instrument_child_student');
    } */

    // Relación con estudiantes
public function students()
{
    return $this->belongsToMany(ChildStudent::class, 'instrument_child_student', 'instrument_id', 'child_student_id');
}


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// ensayo

class Rehearsal extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_rehearsal', 'user_id', 'rehearsal_id')
            ->withPivot('user_type')
            ->withTimestamps();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Concert extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(User::class, 'concert_user', 'user_id', 'concert_id')
            ->withPivot('user_type')
            ->withTimestamps();
    }

}

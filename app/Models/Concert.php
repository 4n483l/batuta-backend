<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Concert extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'place', 'date', 'hour'];
}

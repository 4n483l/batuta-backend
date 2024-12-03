<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index(Request $request)
    {
        return $request->user();
    }

    public function students(Request $request)
    {
        return $request->user()->students;
    }
}

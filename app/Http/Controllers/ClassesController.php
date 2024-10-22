<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classes;

class ClassesController extends Controller
{
    public function index()
    {
        $classes = Classes::all();
        return response()->json(['message' => 'Lista de clases recuperada correctamente', 'Clases' => $classes], 200);
    }
}

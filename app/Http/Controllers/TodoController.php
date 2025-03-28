<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        return view('todo.index'); // Tanpa 'view:' 
    }
    
    public function create()
    {
        return view('todo.create'); // Tanpa 'view:' 
    }
    
    public function edit()
    {
        return view('todo.edit'); // Tanpa 'view:' 
    }
    


    //
}

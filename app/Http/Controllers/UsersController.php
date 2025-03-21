<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function create()
    {
        return view('users/addUser');
    }
    
    public function usersGrid()
    {
        return view('users/usersGrid');
    }

    public function index()
    {
        return view('users/usersList');
    }

    public function edit()
    {
        return view('users/addUser');
    }

    
    
    public function viewProfile()
    {
        return view('users/viewProfile');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{

    public function index()
    {
        $users = User::with('role')->get();

        return view('user.index', compact('users'));
    }
}

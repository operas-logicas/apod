<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getIndex()
    {
        $users = User::orderBy('name', 'asc')->get();
        return view('admin.users.index', ['users' => $users]);
    }
}

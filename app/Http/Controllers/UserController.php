<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUserIndex()
    {
        $users = User::orderBy('name', 'asc')
            ->paginate(10);
        return view('admin.users.index', ['users' => $users]);
    }

    public function getUserCreate() {}

    public function getUserEdit($id) {}

    public function postUserCreate(Request $request) {}

    public function postUserUpdate(Request $request) {}

    public function getUserDelete($id) {}

}

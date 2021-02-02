<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UserViewController extends Controller
{
    public function getUserIndex()
    {
        // Get only logged in user unless superuser
        $user_id = Auth::user()->id;
        if($user_id !== 1) {
            $users = User::where('id', $user_id)
                ->paginate();
        } else {
            // superuser so get all users
            $users = User::orderBy('name', 'asc')
                ->paginate(10);
        }

        return view('admin.users.index', ['users' => $users, 'user_id' => $user_id]);
    }

    public function getUserCreate()
    {
        return view('admin.users.create');
    }

    public function getUserEdit($id)
    {
        $user = User::find($id);
        return view('admin.users.edit', [
            'user' => $user,
            'userId' => $id
        ]);
    }

    public function postUserCreate(Request $request)
    {
        // Check if user is authorized (superuser)
        if(Auth::user()->id !== 1) {
            return redirect()
                ->back()
                ->with('fail', 'Not authorized!');
        }

        // Form validation
        $this->validate($request, [
            'name' => 'required',
            'email' => [
                'required',
                'email'
            ],
            'password' => [
                'required',
                'min:8',
                'regex:/[A-Z]+/',
                'regex:/[a-z]+/',
                'regex:/[0-9]+/',
                'confirmed:password_confirmation'
            ]
        ]);

        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password'))
        ]);

        $user->save();

        return redirect()
            ->route('admin.users.index')
            ->with('info', 'User created, name: ' . $request->input('name'));

    }

    public function postUserUpdate(Request $request)
    {
        $user = User::find($request->input('id'));

        // Check if user is authorized
        if(Gate::denies('change-user', $user)) {
            return redirect()
                ->back()
                ->with('fail', 'Not authorized!');
        }

        // Form validation
        $this->validate($request, [
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id)
            ],
            'password' => [
                'nullable',
                'min:8',
                'regex:/[A-Z]+/',
                'regex:/[a-z]+/',
                'regex:/[0-9]+/',
                'confirmed:password_confirmation'
            ]
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if($request->input('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        return redirect()
            ->route('admin.users.index')
            ->with('info', 'User updated, name: ' . $request->input('name'));
    }

    public function getUserDelete($id)
    {
        $user = User::find($id);

        // Check if user is authorized
        // Prevent superuser from being deleted!
        if($user->id === 1 || Gate::denies('change-user', $user)) {
            return redirect()
                ->back()
                ->with('fail', 'Not authorized!');
        }

        $user->posts()->delete();
        $user->delete();
        return redirect()
            ->route('admin.users.index')
            ->with('info', 'User deleted!');
    }

}

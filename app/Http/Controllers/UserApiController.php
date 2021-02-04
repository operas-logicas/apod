<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', [
            // Anyone can store or login
            'only' => [
                'index', 'show', 'update', 'destroy', 'logout'
            ]
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        foreach($users as $user) {
            $user->show_user = [
                'href' => "api/v1/users/{$user->id}",
                'method' => 'GET'
            ];
        }

        $response = [
            'msg' => 'List of all Users',
            'users' => $users
        ];

        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

        if(!$user->save()) {
            return response()->json([
                'msg' => 'Error during creation'
            ], 500);
        }

        $user->login_user = [
            'href' => "api/v1/users/login",
            'method' => 'POST',
            'params' => 'email, password'
        ];

        $user->show_user = [
            'href' => "api/v1/users/{$user->id}",
            'method' => 'GET'
        ];

        $response = [
            'msg' => 'User created',
            'user' => $user
        ];

        return response()->json($response, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // First check if user exists
        if(!$user = User::find($id)) {
            return response()->json([
                'msg' => 'User not found'
            ], 404);
        }

        $posts = Post::where('user_id', $id)
            ->orderBy('updated_at', 'desc')
            ->get();

        foreach($posts as $post) {
            $post->show_post = [
                'title' => $post->title,
                'href' => "api/v1/posts/{$post->id}",
                'method' => 'GET'
            ];
        }

        $user->user_posts = [
            'msg' => "List of all User's Posts",
            'posts' => $posts
        ];

        // If user is authorized (i.e. is user or is superuser),
        // show update and delete links
        $logged_in_user_id = auth('api')->user()->id;
        if($user->id === $logged_in_user_id || $logged_in_user_id === 1) {
            $user->update_user = [
                'href' => "api/v1/users/{$user->id}",
                'method' => 'PATCH'
            ];

            // Do not show delete link for superuser!
            if($user->id !== 1) {
                $user->delete_user = [
                    'href' => "api/v1/users/{$user->id}",
                    'method' => 'DELETE'
                ];
            }
        }

        $response = [
            'msg' => 'User Info',
            'user' => $user
        ];

        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // First check if user exists
        if(!$user = User::find($id)) {
            return response()->json([
                'msg' => 'User not found'
            ], 404);
        }

        // Check if user is authorized (i.e. is user or is superuser)
        $logged_in_user_id = auth('api')->user()->id;
        if($user->id === $logged_in_user_id || $logged_in_user_id === 1) {
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

            if(!$user->update()) {
                return response()->json([
                    'msg' => 'Error during update'
                ], 500);
            }

            $user->show_user = [
                'href' => "api/v1/users/{$user->id}",
                'method' => 'GET'
            ];

            $response = [
                'msg' => 'User updated',
                'user' => $user
            ];

            return response()->json($response, 201);

        } else {
            // Not authorized
            return response()->json([
                'msg' => 'Unauthorized'
            ], 401);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // First check if user exists
        if(!$user = User::find($id)) {
            return response()->json([
                'msg' => 'User not found'
            ], 404);
        }

        // Check if user is authorized (i.e. is user or is superuser)
        $logged_in_user_id = auth('api')->user()->id;
        if($user->id === $logged_in_user_id || $logged_in_user_id === 1) {
            // Do not delete superuser!
            if($user->id === 1) {
                return response()->json([
                    'msg' => 'Superuser cannot be deleted'
                ], 401);
            }

            $user->posts()->delete();
            if(!$user->delete()) {
                return response()->json([
                    'msg' => 'Error during deletion'
                ], 500);
            }

            $response = [
                'msg' => 'User deleted',
                're-register' => [
                    'href' => 'api/v1/users',
                    'method' => 'POST',
                    'params' => 'name, email, password, password_confirmation'
                ]
            ];

            return response()->json($response, 201);

        } else {
            // Not authorized
            return response()->json([
                'msg' => 'Unauthorized'
            ], 401);
        }

    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if(!$token = auth('api')->attempt($credentials)) {
            return response()->json([
                'msg' => 'Invalid credentials'
            ], 401);
        }

        return response()->json([
            'msg' => 'Successfully logged in',
            'token' => $token,
            'logout' => [
                'href' => 'api/v1/users/logout',
                'method' => 'POST'
            ]
        ], 200);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth('api')->logout();

        return response()->json([
            'msg' => 'Successfully logged out'
        ]);
    }
}

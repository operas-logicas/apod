<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', [
            'only' => [
                'store', 'update', 'destroy'
            ]
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($input = null)
    {
        if($input) {
            // If id supplied, pass to show()
            if(!strstr($input, '-')) {
                return $this->show($input);
            }

            // Else if date supplied, show only posts from date
            $posts = Post::where('date', $input)
                ->where('active', true)
                ->orderBy('updated_at', 'desc')
                ->get();

            $msg = 'List of Active Posts on ' . date('F j, Y', strtotime($input));

        } else {
            // Else show them all
            $posts = Post::where('active', true)
                ->orderBy('date', 'desc')
                ->orderBy('updated_at', 'desc')
                ->get();

            $msg = 'List of all Active Posts';

        }

        $users = User::all();
        $user_names = [];
        foreach($users as $user) {
            $user_names[$user->id] = $user->name;
        }

        foreach($posts as $post) {
            $post->user_posted = $user_names[$post->user_id];
            $post->show_post = [
                'href' => "api/v1/posts/{$post->id}",
                'method' => 'GET'
            ];
        }

        $response = [
            'msg' => $msg,
            'posts' => $posts
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
        // If optional nasa_apod_url param supplied,
        // Use Guzzle to get data from NASA's API
        if($request->input('nasa_apod_url')) {

            $this->validate($request, [
                'nasa_apod_url' => 'required|url'
            ]);

            $client = new Client();

            try {
                $response = $client->request(
                    'GET',
                    $request->input('nasa_apod_url')
                );
            } catch (RequestException $e) {
                return response()->json([
                    'msg' => "Request to NASA's APOD API failed"
                ], 500);
            }

            $json = json_decode($response->getBody());
            $record = $json[0]; // Get only first record if multiple returned

            $post = new Post([
                'date' => date('Y-m-d', time()),
                'img_url' => $record->thumbnail_url ?? $record->url,
                'title' => $record->title,
                'copyright' => $record->copyright ?? null,
                'original_date' => $record->date,
                'explanation' => $record->explanation,
                'active' => true
            ]);

        } else {
            // Else get request params supplied by user
            $this->validate($request, [
                'date' => 'required|date_format:Y-m-d',
                'img_url' => 'required|url',
                'title' => 'required|min:5',
                'original_date' => 'required|date_format:Y-m-d',
                'explanation' => 'required|min:10',
                'active' => 'required|boolean'
            ]);

            $post = new Post([
                'date' => $request->input('date'),
                'img_url' => $request->input('img_url'),
                'title' => $request->input('title'),
                'copyright' => $request->input('copyright'),
                'original_date' => $request->input('original_date'),
                'explanation' => $request->input('explanation'),
                'active' => $request->input('active')
            ]);

        }

        $user = auth('api')->user(); // Get logged in user
        if(!$user->posts()->save($post)) {
            return response()->json([
                'msg' => 'Error during creation'
            ], 500);
        }

        $href = "api/v1/posts/{$post->id}";

        $post->show_post = [
            'href' => $href,
            'method' => 'GET'
        ];

        $post->update_post = [
            'href' => $href,
            'method' => 'PATCH'
        ];

        $post->delete_post = [
            'href' => $href,
            'method' => 'DELETE'
        ];

        $response = [
            'msg' => 'Post created',
            'post' => $post
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
        // First check if post exists
        if(!$post = Post::where('id', $id)
            ->where('active', true)
            ->first()
        ) {
            return response()->json([
                'msg' => 'Post not found'
            ], 404);
        }

        $post->user_posted = User::find($post->user_id)->name;

        $response = [
            'msg' => 'Post Info',
            'post' => $post
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
        // First check if post exists
        if(!$post = Post::find($id)) {
            return response()->json([
                'msg' => 'Post not found'
            ], 404);
        }

        // Check if user is authorized (i.e. is user or is superuser)
        $logged_in_user_id = auth('api')->user()->id;
        if($post->user_id === $logged_in_user_id || $logged_in_user_id === 1) {
            $this->validate($request, [
                'date' => 'nullable|date_format:Y-m-d',
                'img_url' => 'nullable|url',
                'title' => 'nullable|min:5',
                'copyright' => 'nullable',
                'original_date' => 'nullable|date_format:Y-m-d',
                'explanation' => 'nullable|min:10',
                'active' => 'nullable|boolean'
            ]);

            $post->date = $request->input('date') ?? $post->date;
            $post->img_url = $request->input('img_url') ?? $post->img_url;
            $post->title = $request->input('title') ?? $post->title;
            $post->copyright = $request->input('copyright') ?? $post->copyright;
            $post->original_date = $request->input('original_date') ?? $post->original_date;
            $post->explanation = $request->input('explanation') ?? $post->explanation;
            $post->active = $request->input('active') ?? $post->active;

            if(!$post->update()) {
                return response()->json([
                    'msg' => 'Error during update'
                ], 500);
            }

            $post->show_post = [
                'href' => "api/v1/posts/{$post->id}",
                'method' => 'GET'
            ];

            $response = [
                'msg' => 'Post updated',
                'post' => $post
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
        // First check if post exists
        if(!$post = Post::find($id)) {
            return response()->json([
                'msg' => 'Post not found'
            ], 404);
        }

        // Check if user is authorized (i.e. is user or is superuser)
        $logged_in_user_id = auth('api')->user()->id;
        if($post->user_id === $logged_in_user_id || $logged_in_user_id === 1) {
            if(!$post->delete()) {
                return response()->json([
                    'msg' => 'Error during deletion'
                ], 500);
            }

            $response = [
                'msg' => 'Post deleted',
                'create_new_post' => [
                    'href' => 'api/v1/posts',
                    'method' => 'POST',
                    'params' => 'nasa_apod_url OR date, img_url, title, (copyright), original_date, explanation, active'
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
}

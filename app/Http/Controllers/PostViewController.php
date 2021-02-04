<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PostViewController extends Controller
{
    public function getIndex($date = null)
    {
        if($date) {
            // If date supplied, show only posts from date
            $posts = Post::where('date', $date)
                ->where('active', true)
                ->orderBy('updated_at', 'desc')
                ->paginate();

        } else {
            // Else show them all
            $posts = Post::where('active', true)
                ->orderBy('date', 'desc')
                ->orderBy('updated_at', 'desc')
                ->paginate(5);
        }

        // Get the users' names to display in posts
        $users = [];
        foreach($posts as $post) {
            $users[$post->id] = User::find($post->user_id)->name;
        }

        return view('index', ['posts' => $posts, 'users' => $users, 'date' => $date]);
    }

    public function getPost($id)
    {
        $post = Post::where('id', $id)
            ->where('active', true)
            ->first();

        if(!$post) {
            return redirect()
                ->route('index');
        }

        $user_name = User::find($post->user_id)->name;

        return view('post', ['post' => $post, 'user_name' => $user_name]);
    }

    public function getAdminIndex()
    {
        // Get only logged in user's posts unless superuser
        $user_id = Auth::user()->id;
        if($user_id !== 1) {
            $posts = Post::where('user_id', $user_id)
                ->orderBy('date', 'desc')
                ->orderBy('updated_at', 'desc')
                ->paginate(10);
        } else {
            // superuser so get all posts
            $posts = Post::orderBy('date', 'desc')
                ->orderBy('updated_at', 'desc')
                ->paginate(10);
        }

        return view('admin.posts.index', ['posts' => $posts]);
    }

    public function getAdminCreate()
    {
        return view('admin.posts.create');
    }

    public function getAdminEdit($id)
    {
        $post = Post::find($id);
        return view('admin.posts.edit', [
            'post' => $post,
            'postId' => $id
        ]);
    }

    public function postAdminCreate(Request $request)
    {
        // Form validation
        $this->validate($request, [
            'date' => 'required|date_format:Y-m-d',
            'img_url' => 'required|url',
            'title' => 'required|min:5',
            'original_date' => 'required|date_format:Y-m-d',
            'explanation' => 'required|min:10',
            'active' => 'required|boolean'
        ]);

        $user = Auth::user();
        $post = new Post([
            'date' => $request->input('date'),
            'img_url' => $request->input('img_url'),
            'title' => $request->input('title'),
            'copyright' => $request->input('copyright'),
            'original_date' => $request->input('original_date'),
            'explanation' => $request->input('explanation'),
            'active' => $request->input('active')
        ]);

        $user->posts()->save($post);

        return redirect()
            ->route('admin.posts.index')
            ->with('info', 'Post created, title: ' . $request->input('title'));
    }

    public function postAdminUpdate(Request $request)
    {
        // Form validation
        $this->validate($request, [
            'date' => 'required|date_format:Y-m-d',
            'img_url' => 'required|url',
            'title' => 'required|min:5',
            'original_date' => 'required|date_format:Y-m-d',
            'explanation' => 'required|min:10',
            'active' => 'required|boolean'
        ]);

        $post = POST::find($request->input('id'));

        // Check if user is authorized
        if(Gate::denies('change-post', $post)) {
            return redirect()
                ->back()
                ->with('fail', 'Not authorized!');
        }

        $post->date = $request->input('date');
        $post->img_url = $request->input('img_url');
        $post->title = $request->input('title');
        $post->copyright = $request->input('copyright');
        $post->original_date = $request->input('original_date');
        $post->explanation = $request->input('explanation');
        $post->active = $request->input('active');

        $post->save();

        return redirect()
            ->route('admin.posts.index')
            ->with('info', 'Post updated, title: ' . $request->input('title'));
    }

    public function getAdminDelete($id)
    {
        $post = Post::find($id);

        // Check if user is authorized
        if(Gate::denies('change-post', $post)) {
            return redirect()
                ->back()
                ->with('fail', 'Not authorized!');
        }

        $post->delete();

        return redirect()
            ->route('admin.posts.index')
            ->with('info', 'Post deleted!');
    }

}

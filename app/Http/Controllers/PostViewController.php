<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostViewController extends Controller
{
    public function getIndex($date = null)
    {
        if($date) {
            $posts = Post::where('date', $date)
                ->where('active', true)
                ->orderBy('created_at', 'desc')
                ->Paginate();
        } else {
            $posts = Post::where('active', true)
                ->orderBy('date', 'desc')
                ->orderBy('created_at', 'desc')
                ->Paginate(4);
        }

        return view('index', ['posts' => $posts]);
    }

    public function getPost($id)
    {
        $post = Post::where('id', $id)
            ->where('active', true)
            ->first();

        return view('post', ['post' => $post]);
    }

    public function getAdminIndex($date = null)
    {
        if($date) {
            $posts = Post::where('date', $date)
                ->orderBy('created_at', 'desc')
                ->Paginate();
        } else {
            $posts = Post::orderBy('created_at', 'desc')
                ->Paginate(8);
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
        return view('admin.posts.edit', ['post' => $post]);
    }

    public function postAdminCreate(Request $request) {}

    public function postAdminEdit(Request $request) {}

    public function getAdminDelete($id) {}

}

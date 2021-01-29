<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function getIndex() {
        $posts = Post::orderBy('date', 'desc')->get();
        return view('index', ['posts' => $posts]);
    }

    public function getAdminIndex() {
        $posts = Post::orderBy('date', 'desc')->get();
        return view('admin.posts.index', ['posts' => $posts]);
    }
}

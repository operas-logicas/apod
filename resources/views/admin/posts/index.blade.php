@extends('layouts.master')

@section('content')

    @include('partials.admin')

    <div class="mt-5">
        <a href="{{ route('posts.create') }}" class="btn btn-sm btn-success">New Post</a>
    </div>
    <hr>
    @foreach($posts as $post)
        <div class="row">
            <div class="col-md-12">
                <p><strong>{{ $post->date }}</strong>
                    <a class="badge badge-sm badge-warning mx-1" href="{{ route('posts.edit') }}">Edit</a>
                    <a class="badge badge-sm badge-danger mx-1" href="#">Delete</a>
                </p>
            </div>
        </div>
    @endforeach
@endsection

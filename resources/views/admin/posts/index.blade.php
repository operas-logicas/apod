@extends('layouts.master')

@section('content')

    @include('partials.admin')

    <div class="row mt-5">
        <div class="col-md-12">
            <a href="{{ route('admin.posts.create') }}" class="btn btn-sm btn-success">New Post</a>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <p class="p-1 bg-light">
                <strong>KEY: &nbsp;&nbsp;</strong>
                <span>Active &nbsp;&nbsp;</span>
                <span class="text-black-50">Disabled</span>
            </p>
        </div>
    </div>
    @foreach($posts as $post)
        <div class="row">
            <div class="col-md-12">
                <p class="{{ !$post->active ? 'text-black-50' : '' }}"><strong>{{ $post->date }}</strong> - {{ $post->title }}
                    @if(!Gate::denies('change-post', $post))
                        <a class="badge badge-sm badge-warning mx-1" href="{{ route('admin.posts.edit', $post->id) }}">Edit</a>
                        <a class="post_delete badge badge-sm badge-danger mx-1" href="{{ route('admin.posts.delete', $post->id) }}">Delete</a>
                    @endif
                </p>
            </div>
        </div>
    @endforeach
    <div class="row mt-5 pb-5">
        <div class="col-md-12 text-center">
            {{ $posts->links() }}
        </div>
    </div>
@endsection

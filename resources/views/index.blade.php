@extends('layouts.master')

@section('content')
    <h1 class="display-3 pb-3">Astronomy Picture of the Day</h1>
    @foreach($posts as $post)
        <div class="row mt-3 pb-3">
            <div class="col">
                <h2>{{ $post->date }}</h2>
                <img class="img-fluid" src="{{ $post->img_url }}">
                <figcaption class="figure-caption">{{ $post->title }}</figcaption>
                <p class="mt-3 pb-3">{{ $post->explanation }}</p>
            </div>
        </div>
    @endforeach
@endsection

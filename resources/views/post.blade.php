@extends('layouts.master')

@section('content')
    <h1 class="display-3 pb-3">Astronomy Pictures of the Day</h1>
    <div class="row mt-3 pb-3">
        <div class="col">
            <h3>{{ $post->title }}</h3>
            <h6>Posted by {{ $user_name }}</h6>
            <p class="mt-n2">{{ $post->date }}</p>
            <img class="img-fluid" src="{{ $post->img_url }}">
            <figcaption class="figure-caption">
                {{ $post->copyright ? " (Copyright {$post->copyright})" : '' }}
            </figcaption>
            <p class="mt-3">{{ $post->explanation }}</p>
            <small class="pb-3">(Originally posted on <a href="http://apod.nasa.gov/apod/astropix.html">NASA APOD</a> {{ $post->original_date }})</small>
        </div>
    </div>
@endsection

@extends('layouts.master')

@section('content')
    <h1 class="display-3 pb-3">Astronomy Pictures of the Day</h1>
    @foreach($posts as $post)
        <div class="row mt-3 pb-3">
            <div class="col">
                <h2>{{ $post->date }}</h2>
                <img class="img-fluid" src="{{ $post->img_url }}">
                <figcaption class="figure-caption">
                    {{ $post->title }}
                    {{ $post->copyright ? " (Copyright {$post->copyright})" : '' }}
                </figcaption>
                <p class="mt-3">{{ $post->explanation }}</p>
                <small class="pb-3">(Original published on <a href="http://apod.nasa.gov/apod/astropix.html">NASA APOD</a> {{ $post->original_date }})</small>
            </div>
        </div>
    @endforeach
    <div class="row mt-5 pb-5">
        <div class="col-md-12 text-center">
            {{ $posts->links() }}
        </div>
    </div>
@endsection

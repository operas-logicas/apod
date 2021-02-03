@extends('layouts.master')

@section('content')
    <h1 class="display-3 pb-3">Astronomy Pictures of the Day</h1>
    @if( Request::routeIs('index.date'))
        <h2 class="pb-5">{{ date('F j, Y', strtotime($date)) }}</h2>
    @endif
    @foreach($posts as $post)
        <div class="row mt-3 pb-5">
            <div class="col">
                <h3><a style="color: #212529 !important" href="{{ route('index.post', $post->id) }}">{{ $post->title }}</a></h3>
                <h6>Posted by {{ $users[$post->id] }}</h6>
                <p class="mt-n2">{{ $post->date }}</p>
                <img class="img-fluid" src="{{ $post->img_url }}">
                <figcaption class="figure-caption">
                    {{ $post->copyright ? " (Copyright {$post->copyright})" : '' }}
                </figcaption>
                <p class="mt-3">{{ $post->explanation }}</p>
                <small class="pb-3">(Originally posted on <a href="http://apod.nasa.gov/apod/astropix.html">NASA APOD</a> {{ $post->original_date }})</small>
            </div>
        </div>
    @endforeach
    <div class="row mt-5 pb-5">
        <div class="col-md-12 text-center">
            {{ $posts->links() }}
        </div>
    </div>
@endsection

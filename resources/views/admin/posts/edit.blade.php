@extends('layouts.master')

@section('content')

    @include('partials.admin')

    <h3 class="mt-5">Edit Post</h3>
    <div class="row mt-3 pb-5">
        <div class="col-md-12">
            <p><em>Please only edit for formatting to preserve accurate information.</em></p>
            <form action="{{ route('admin.posts.update') }}" method="post">
                <div class="form-group">
                    <label for="active">Active</label>
                    <input type="hidden" name="active" value="0">
                    <input
                        type="checkbox"
                        class="form-check form-check-inline ml-1"
                        id="active"
                        name="active"
                        value="1"
                        {{ $post->active ? 'checked' : '' }}
                    >
                </div>
                <div class="form-group">
                    <label for="date">Date</label>
                    <input
                        type="date"
                        class="form-control"
                        id="date"
                        name="date"
                        value="{{ date('Y-m-d', strtotime($post->date)) }}"
                    >
                </div>
                <div class="form-group">
                    <label for="img_url">Image URL</label>
                    <input
                        type="text"
                        class="form-control"
                        id="img_url"
                        name="img_url"
                        value="{{ $post->img_url }}"
                    >
                </div>
                <div class="form-group">
                    <label for="title">Title</label>
                    <input
                        type="text"
                        class="form-control"
                        id="title"
                        name="title"
                        value="{{ $post->title }}"
                    >
                </div>
                <div class="form-group">
                    <label for="copyright">Copyright</label>
                    <input
                        type="text"
                        class="form-control"
                        id="copyright"
                        name="copyright"
                        value="{{ $post->copyright }}"
                    >
                </div>
                <div class="form-group">
                    <label for="original_date">Original Posted Date</label>
                    <input
                        type="date"
                        class="form-control"
                        id="original_date"
                        name="original_date"
                        value="{{ date('Y-m-d', strtotime($post->original_date)) }}"
                    >
                </div>
                <div class="form-group">
                    <label for="explanation">Explanation</label>
                    <textarea
                        class="form-control"
                        id="explanation"
                        name="explanation"
                        rows="10"
                    >{{ $post->explanation }}</textarea>
                </div>
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $postId }}">
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection

@extends('layouts.master')

@section('content')

    @include('partials.admin')

    <h3 class="mt-5">New Post</h3>
    <div class="row mt-3">
        <div class="col-md-12">
            <form action="#" method="post">
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" class="form-control" id="date" name="date">
                </div>
                <div class="form-group">
                    <label for="img_url">Image URL</label>
                    <input class="form-control" id="img_url" name="img_url">
                </div>
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title">
                </div>
                <div class="form-group">
                    <label for="explanation">Explanation</label>
                    <textarea class="form-control" id="explanation" name="explanation" rows="10"></textarea>
                </div>
                {{ csrf_field() }}
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection

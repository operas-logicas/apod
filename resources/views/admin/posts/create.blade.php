@extends('layouts.master')

@section('content')

    @include('partials.admin')

    <h3 class="mt-5">New Post</h3>
    <div class="row mt-3 pb-5">
        <div class="col-md-12">
            <form action="{{ route('admin.posts.create') }}" method="post">
                <div class="form-group">
                    <label for="active">Active</label>
                    <input type="hidden" name="active" value="0">
                    <input type="checkbox" class="form-check form-check-inline ml-1" id="active" name="active" value="1">
                </div>
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" class="form-control" id="date" name="date">
                </div>
                <div class="form-group">
                    <label for="img_url">Image URL</label>
                    <input type="text" class="form-control" id="img_url" name="img_url">
                </div>
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title">
                </div>
                <div class="form-group">
                    <label for="copyright">Copyright</label>
                    <input type="text" class="form-control" id="copyright" name="copyright">
                </div>
                <div class="form-group">
                    <label for="original_date">Original Published Date</label>
                    <input type="date" class="form-control" id="original_date" name="original_date">
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

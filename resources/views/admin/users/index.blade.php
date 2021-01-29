@extends('layouts.master')

@section('content')

    @include('partials.admin')

    <div class="mt-5">
        <a href="#" class="btn btn-sm btn-success">New User</a>
    </div>
    <hr>
    @foreach($users as $user)
        <div class="row">
            <div class="col-md-12">
                <p><strong>{{ $user->name }}</strong>
                    (<strong>{{ $user->email }}</strong>)
                    <a class="badge badge-sm badge-warning mx-1" href="#">Edit</a>
                    <a class="badge badge-sm badge-danger mx-1" href="#">Delete</a>
                </p>
            </div>
        </div>
    @endforeach
@endsection

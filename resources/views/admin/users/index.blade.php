@extends('layouts.master')

@section('content')

    @include('partials.admin')

    <div class="mt-5">
        <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-success">New User</a>
    </div>
    <hr>
    @foreach($users as $user)
        <div class="row">
            <div class="col-md-12">
                <p><strong>{{ $user->name }}</strong>
                    ({{ $user->email }})
                    <a class="badge badge-sm badge-warning mx-1" href="{{ route('admin.users.edit', $user->id) }}">Edit</a>
                    <a class="badge badge-sm badge-danger mx-1" href="{{ route('admin.users.delete', $user->id) }}">Delete</a>
                </p>
            </div>
        </div>
    @endforeach
    <div class="row mt-5 pb-5">
        <div class="col-md-12 text-center">
            {{ $users->links() }}
        </div>
    </div>
@endsection

@extends('layouts.master')

@section('content')

    @include('partials.admin')

    @if(Auth::user()->id === 1)
        <div class="row mt-5">
            <div class="col-md-12">
                <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-success">New User</a>
            </div>
        </div>
        <hr>
    @else
        <div class="row mt-3">
            &nbsp;
        </div>
    @endif
    @foreach($users as $user)
        <div class="row">
            <div class="col-md-12">
                <p><strong>{{ $user->name }}</strong>
                    ({{ $user->email }})
                    @if(!Gate::denies('change-user', $user))
                        <a class="badge badge-sm badge-warning mx-1" href="{{ route('admin.users.edit', $user->id) }}">Edit</a>
                        @if($user->id === 1)
                            <em>- SUPERUSER <small>(cannot be deleted)</small></em>
                        @else
                            <a class="user_delete badge badge-sm badge-danger mx-1" href="{{ route('admin.users.delete', $user->id) }}">Delete</a>
                        @endif
                    @endif
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

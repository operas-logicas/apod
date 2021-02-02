@extends('layouts.master')

@section('content')

    @include('partials.admin')

    <h3 class="mt-5">Edit User</h3>
    <div class="row mt-3 pb-5">
        <div class="col-md-12">
            <form action="{{ route('admin.users.update') }}" method="post">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input
                        type="text"
                        class="form-control"
                        id="name"
                        name="name"
                        value="{{ $user->name }}"
                    >
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input
                        type="email"
                        class="form-control"
                        id="email"
                        name="email"
                        value="{{ $user->email }}"
                    >
                </div>
                <div class="form-group">
                    <label for="password">Password <small>(Must have 1 uppercase letter, lowercase letter, and number)</small></label>
                    <input
                        type="password"
                        class="form-control"
                        id="password"
                        name="password"
                        value=""
                    >
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input
                        type="password"
                        class="form-control"
                        id="password_confirmation"
                        name="password_confirmation"
                        value=""
                    >
                </div>
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $userId }}">
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection

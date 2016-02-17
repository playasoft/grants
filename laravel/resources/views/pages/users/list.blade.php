@extends('app')

@section('content')
    <h1>All Users</h1>
    <hr>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th>Role</th>
                <th>Email</th>
            </tr>
        </thead>

        <tbody>
            @foreach($users as $user)
                <tr>
                    <td><a href="/users/{{ $user->id }}">{{ $user->name }}</a></td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->email }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@extends('app')

@section('content')
    <h1>All Users</h1>
    <hr>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>User Name</th>
                <th>Burner Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Date Registered</th>
                @if(in_array(Auth::user()->role, ['admin']))
                    <th>Edit User</th>
                @endif
            </tr>
        </thead>

        <tbody>
            @foreach($users as $user)
                <tr>
                    <td><a href="/users/{{ $user->id }}">{{ $user->name }}</a></td>
                    <td>{{ $user->data->burner_name or ''}}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                    @if(in_array(Auth::user()->role, ['admin']))
                        <td><a href="/users/{{ $user->id }}/edit">(edit)</a></td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

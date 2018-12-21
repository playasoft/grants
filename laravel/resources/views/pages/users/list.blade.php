@extends('app')

@section('content')
    <h1>All Users</h1>
        <form class="input-group user-search" method="GET" action="/users">
            <input type="text" name="search" class=" form-control" placeholder="search by username">
            <div class="input-group-btn">
                <button type="submit" class=" btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
            </div>
            
          
        </form>
    
        
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

        <tbody >
            @foreach($users as $user)
                <tr>
                    <td><a href="/users/{{ $user->id }}">{{ $user->name }}</a></td>
                    <td>{{ $user->data->burner_name or ''}}</td>
                    <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                    @if(in_array(Auth::user()->role, ['admin']))
                        <td><a href="/users/{{ $user->id }}/edit">(edit)</a></td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
    @if($users instanceof \Illuminate\Pagination\LengthAwarePaginator )
        {{$users->links()}}
    @endif
@endsection

@extends('app')

@section('content')
    <h1>Viewing User:  <b>{{ $user->name }} </b> </h1>
    <hr>

    @if(in_array(Auth::user()->role, ['admin']))
        <a href="/users/{{ $user->id }}/edit">(edit)</a>
    @endif

    <div class="profile">
        <div class="row">
            <div class="col-sm-2 title">Username</div>
            <div class="col-sm-10 value">{{ $user->name }}</div>
        </div>

        <div class="row">
            <div class="col-sm-2 title">Email</div>
            <div class="col-sm-10 value"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></div>
        </div>

        <div class="row">
            <div class="col-sm-2 title">Role</div>
            <div class="col-sm-10 value">{{ $user->role }}</div>
        </div>

        <div class="row">
            <div class="col-sm-2 title">User_ID</div>
            <div class="col-sm-10 value">{{ $user->id }}</div>
        </div>

        <div class="row">
            <div class="col-sm-2 title">Created</div>
            <div class="col-sm-10 value">{{ $user->created_at->format('Y-m-d') }}</div>
        </div>

        <h3>Profile</h3>

         <div class="row">
            <div class="col-sm-2 title">Burner Name</div>
            <div class="col-sm-10 value">{{ $user->data->burner_name or 'Not Provided' }}</div>
        </div>

        <div class="row">
            <div class="col-sm-2 title">Real Name</div>
            <div class="col-sm-10 value">{{ $user->data->real_name or 'Not Provided' }}</div>
        </div>

        <div class="row">
            <div class="col-sm-2 title">Address</div>
            <div class="col-sm-10 value">{{ $user->data->address or 'Not Provided' }}</div>
        </div>

        <div class="row">
            <div class="col-sm-2 title">Phone</div>
            <div class="col-sm-10 value">{{ $user->data->phone or 'Not Provided' }}</div>
        </div>
    </div>
    <div>
    <h2>Applications</h2>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th>Status</th>
                <th>Judge Status</th>
                <th>Score</th>
                <th>Created</th>
                <th>Last Modified</th>
            </tr>
        </thead>

        <tbody>
            @foreach($user->applications as $application)
                <tr>
                    <td>
                        @if($application->status == 'new')
                            <a href="/applications/{{ $application->id }}">{{ $application->name }}</a>
                        @else
                            <a href="/applications/{{ $application->id }}/review">{{ $application->name }}</a>
                        @endif
                    </td>
                    <td>{{ $application->status }}</td>
                    <td>{{ $application->judge_status }}</td>
                    <td>{{ $application->objective_score }} / {{ $application->subjective_score }} / {{ $application->total_score }}</td>
                    <td>{{ $application->created_at->format('Y-m-d H:i:s e') }}</td>
                    <td>{{ $application->updated_at->format('Y-m-d H:i:s e') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
@endsection

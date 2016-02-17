@extends('app')

@section('content')
    <h1>Viewing User: {{ $user->name }}</h1>
    <hr>

    <div class="profile">
        <div class="row">
            <div class="col-sm-2 title">Username</div>
            <div class="col-sm-10 value">{{ $user->name }}</div>
        </div>

        <div class="row">
            <div class="col-sm-2 title">Email</div>
            <div class="col-sm-10 value">{{ $user->email }}</div>
        </div>
        <div class="row">
            <div class="col-sm-2 title">User_ID</div>
            <div class="col-sm-10 value">{{ $user->id }}</div>
        </div>

        <div class="row">
            <div class="col-sm-2 title">Created</div>
            <div class="col-sm-10 value">{{ $user->created_at->format('Y-m-d') }}</div>
        </div>

        <h3>Additional information</h3>

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
@endsection

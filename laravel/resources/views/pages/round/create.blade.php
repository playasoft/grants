@extends('app')

@section('content')
    <h1>Create Application Grant Round</h1>
    <hr>
    
    {!! Form::open(['url' => 'rounds']) !!}
        <p>[todo]</p>

        <button type="submit" class="btn btn-primary">Create New Grant Round</button>
    {!! Form::close() !!}
@endsection

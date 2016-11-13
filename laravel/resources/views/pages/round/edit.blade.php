@extends('app')

@section('content')
    <h1>Edit Grant Round</h1>
    <hr>
    
    {!! Form::open() !!}
        <p>[Todo]</p>

        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="/rounds/{{ $round->id }}/delete" class="btn btn-danger delete-round">Delete Round</a>
    {!! Form::close() !!}
@endsection

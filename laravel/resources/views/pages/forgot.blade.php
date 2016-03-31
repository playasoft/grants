@extends('app')

@section('content')
    <h1>Forgot your password?</h1>
    <hr>

    {!! Form::open() !!}
        @include('partials/form/text', ['name' => 'user', 'label' => 'Username or Email', 'placeholder' => 'Enter your username or your email address'])

        <button type="submit" class="btn btn-primary">Submit</button>
    {!! Form::close() !!}
@endsection

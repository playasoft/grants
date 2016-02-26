@extends('app')

@section('content')
    <h1>Edit Your Profile</h1>
    <hr>

    {!! Form::open() !!}
        <input type="hidden" name="type" value="data">

        @include('partials/form/text', ['name' => 'burner_name', 'label' => 'Burner Name', 'placeholder' => 'Your name on the Playa', 'value' => (is_null($user->data)) ? '' : $user->data->burner_name])
        @include('partials/form/text', ['name' => 'real_name', 'label' => 'Real Name', 'placeholder' => 'Your name in the Default World', 'value' => (is_null($user->data)) ? '' : $user->data->real_name])
        @include('partials/form/textarea', ['name' => 'address', 'label' => 'Address', 'placeholder' => 'Your name mailing address', 'value' => (is_null($user->data)) ? '' : $user->data->address])
        @include('partials/form/text', ['name' => 'phone', 'label' => 'Phone Number', 'placeholder' => 'Your name 10 digit phone number', 'value' => (is_null($user->data)) ? '' : $user->data->phone])

        <button type="submit" class="btn btn-success">Save Changes</button>
        <a href="/profile" class="btn btn-primary">Cancel</a>
    {!! Form::close() !!}
@endsection

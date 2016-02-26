@extends('app')

@section('content')
    <h1>Edit User: <b>{{ $user->name }}</b></h1>
    <hr>
    <div class="form-group">
        {!! Form::open() !!}
        <input type="hidden" name="type" value="user">

        @include('partials/form/text', ['name' => 'name', 'label' => 'User Name', 'value' => $user->name, 'class' => 'form-control'])
        @include('partials/form/text', ['name' => 'email', 'label' => 'Email', 'value' => $user->email, 'class' => 'form-control', 'rows' => 3])
        @include('partials/form/select',
        [
            'name' => 'role',
            'label' => 'User Role',
            'options' =>
            [
                'applicant' => "Applicant",
                'judge' => "Judge",
                'observer' => "Observer",
                'admin' => "Admin",
            ],
            'value' => $user->role
        ])

        <div class="row">
            <div class="col-sm-2 title">User_ID</div>
            <div class="col-sm-10 value">{{ $user->id }}</div>
        </div>

        <div class="row">
            <div class="col-sm-2 title">Created</div>
            <div class="col-sm-10 value">{{ $user->created_at->format('Y-m-d') }}</div>
        </div>

        <button type="submit" class="btn btn-success">Save Changes</button>
        <a href="/profile" class="btn btn-primary">Cancel</a>
    {!! Form::close() !!}
    </div>
    <hr>
    <h2>Profile Information</h2>

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

@extends('app')

@section('content')
    <h1>Create Application Grant Round</h1>
    <hr>
    
    {!! Form::open(['url' => 'rounds']) !!}
        @include('partials/form/text', ['name' => 'name', 'label' => 'Short name for this Round', 'placeholder' => "Big Money Round"])
        @include('partials/form/textarea',
        [
            'name' => 'description',
            'label' => 'Description',
            'help' => 'This description appears on the home page while the round is active.',
            'placeholder' => "Apogaea has $1,000,000 in art grant awesome-ness this year! " .
                                "This is the first creative grant round we are doing this year with a cap of $50,000 per application and a total of $750,000 available this round. " .
                                "Please register and fill out an art grant application today!"
        ])
        @include('partials/form/text', ['name' => 'budget', 'label' => 'Budget available for this round', 'placeholder' => "$750,000"])
        @include('partials/form/text', ['name' => 'min_request_amount', 'label' => 'Minimum application amount', 'placeholder' => "$600"])
        @include('partials/form/text', ['name' => 'max_request_amount', 'label' => 'Maximum application amount', 'placeholder' => "$20,000"])
        @include('partials/form/date', ['name' => 'start_date', 'label' => 'Start Date', 'placeholder' => "2020-12-15"])
        @include('partials/form/date', ['name' => 'end_date', 'label' => 'End Date', 'placeholder' => "2021-1-15"])

        <button type="submit" class="btn btn-primary">Create New Grant Round</button>
    {!! Form::close() !!}
@endsection

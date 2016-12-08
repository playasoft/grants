@extends('app')

@section('content')
    <h1>Edit Grant Round</h1>
    <hr>
    
    {!! Form::open() !!}
        @include('partials/form/text', ['value' => $round->name, 'name' => 'name', 'label' => 'Short name for this Round', 'placeholder' => "Big Money Round"])
        @include('partials/form/textarea',
        [
            'value' => $round->description,
            'name' => 'description',
            'label' => 'Description',
            'help' => 'This description appears on the home page while the round is active.',
            'placeholder' => "Apogaea has $1,000,000 in art grant awesome-ness this year! " .
                                "This is the first creative grant round we are doing this year with a cap of $50,000 per application and a total of $750,000 available this round. " .
                                "Please register and fill out an art grant application today!"
        ])
        @include('partials/form/text', ['value' => $round->budget, 'name' => 'budget', 'label' => 'Budget available for this round', 'placeholder' => "$750,000"])
        @include('partials/form/text', ['value' => $round->min_request_amount, 'name' => 'min_request_amount', 'label' => 'Minimum application amount', 'placeholder' => "$600"])
        @include('partials/form/text', ['value' => $round->max_request_amount, 'name' => 'max_request_amount', 'label' => 'Maximum application amount', 'placeholder' => "$20,000"])
        @include('partials/form/date', ['value' => $round->start_date, 'name' => 'start_date', 'label' => 'Start Date', 'placeholder' => "2020-12-15"])
        @include('partials/form/date', ['value' => $round->end_date, 'name' => 'end_date', 'label' => 'End Date', 'placeholder' => "2021-1-15"])

        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="/rounds/{{ $round->id }}/delete" class="btn btn-danger delete-round">Delete Round</a>
    {!! Form::close() !!}
@endsection

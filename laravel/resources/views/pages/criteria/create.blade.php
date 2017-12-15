@extends('app')

@section('content')
    <h1>Create Judge Criteria</h1>
    <hr>

    {!! Form::open(['url' => 'criteria']) !!}
        @include('partials/form/select',
        [
            'name' => 'round_id',
            'label' => 'Round',
            'options' => $roundDropdown,
        ])

        @include('partials/form/text', ['name' => 'question', 'label' => 'Question', 'placeholder' => "What would you like to know?"])

        @include('partials/form/select',
        [
            'name' => 'type',
            'label' => 'Type of Criteria',
            'options' =>
            [
                'objective' => "Objective",
                'subjective' => "Subjective",
            ]
        ])

        @include('partials/form/checkbox', ['name' => 'required', 'label' => 'Is this criteria required?', 'options' => ['Yes']])

        <button type="submit" class="btn btn-primary">Submit New Criteria</button>
    {!! Form::close() !!}
@endsection

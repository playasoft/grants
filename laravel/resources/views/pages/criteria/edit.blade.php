@extends('app')

@section('content')
    <h1>Edit Criteria</h1>
    <hr>

    {!! Form::open() !!}
        @include('partials/form/select',
        [
            'name' => 'round_id',
            'label' => 'Round',
            'options' => $roundDropdown,
            'value' => $criteria->round_id
        ])

        @include('partials/form/text', ['name' => 'question', 'label' => 'Question', 'placeholder' => "What would you like to know?", 'value' => $criteria->question])

        @include('partials/form/select',
        [
            'name' => 'type',
            'label' => 'Type of Criteria',
            'options' =>
            [
                'objective' => "Objective",
                'subjective' => "Subjective",
            ],
            'value' => $criteria->type
        ])

        @include('partials/form/checkbox', ['name' => 'required', 'label' => 'Is this criteria required?', 'options' => ['Yes'], 'value' => $criteria->required])

        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="/criteria/{{ $criteria->id }}/delete" class="btn btn-danger delete-criteria">Delete Criteria</a>
    {!! Form::close() !!}
@endsection

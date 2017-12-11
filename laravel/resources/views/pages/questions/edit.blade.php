@extends('app')

@section('content')
    <h1>Edit Question</h1>
    <hr>

    {!! Form::open() !!}
        @include('partials/form/text', ['name' => 'question', 'label' => 'Question', 'placeholder' => "What would you like to know?", 'value' => $question->question])

        @include('partials/form/select',
        [
            'name' => 'type',
            'label' => 'Type of Answer',
            'class' => 'answer-type',
            'options' =>
            [
                'input' => "Short Sentence",
                'text' => "Paragraph",
                'dropdown' => "Multiple Choice",
                'boolean' => "Yes / No",
                'file' => "File Upload",
                'budget' => 'Itemized Budget',
            ],
            'value' => $question->type
        ])

        <div class="question-options hidden">
            @include('partials/form/textarea',
            [
                'name' => 'options',
                'label' => 'Options',
                'placeholder' => 'value : Text Displayed',
                'help' => "When creating a dropdown, you'll need to provide what values will appear.",
                'value' => $question->options
            ])
        </div>

        @include('partials/form/textarea', ['name' => 'help', 'label' => 'Help Text', 'placeholder' => "Additional information for the applicant", 'value' => $question->help])

        @include('partials/form/checkbox', ['name' => 'required', 'label' => 'Is this question required?', 'options' => ['Yes'], 'value' => $question->required])

        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="/questions/{{ $question->id }}/delete" class="btn btn-danger delete-question">Delete Question</a>
    {!! Form::close() !!}
@endsection

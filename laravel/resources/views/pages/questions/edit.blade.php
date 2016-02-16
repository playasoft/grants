@extends('app')

@section('content')
    <h1>Create a Question</h1>
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
 
        @include('partials/form/select',
        [
            'name' => 'role',
            'label' => 'User Role',
            'help' => "A user will only see this question if they have a matching user role.",
            'options' =>
            [
                'applicant' => "Applicant",
                'judge' => "Judge",
            ],
            'value' => $question->role
        ])

        @include('partials/form/checkbox', ['name' => 'required', 'label' => 'Is this question required?', 'options' => ['Yes'], 'value' => $question->required])

        <button type="submit" class="btn btn-primary">Submit New Question</button>
    {!! Form::close() !!}
@endsection

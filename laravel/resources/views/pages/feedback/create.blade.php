@extends('app')

@section('content')
    <h1>Request Feedback from User</h1>
    <hr>
    
    {!! Form::open(['url' => 'feedback']) !!}
        @include('partials/form/text', ['name' => 'question', 'label' => 'Question', 'placeholder' => "What would you like to know?"])

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
            ]
        ])
        
        <div class="question-options hidden">
            @include('partials/form/textarea',
            [
                'name' => 'options',
                'label' => 'Options',
                'placeholder' => 'value : Text Displayed',
                'help' => "When creating a dropdown, you'll need to provide what values will appear."
            ])
        </div>

        <button type="submit" class="btn btn-primary">Request Feedback</button>
    {!! Form::close() !!}
@endsection

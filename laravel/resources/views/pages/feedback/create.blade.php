@extends('app')

@section('content')
    <h1>Request Feedback from User</h1>
    <hr>

    {!! Form::open(['url' => 'feedback']) !!}
        <input type="hidden" name="application_id" value="{{ $application->id }}">
        <input type="hidden" name="regarding_type" value="general">
        @if($question->exists)
            <input type="hidden" name="regarding_id" value="{{ $question->id }}">
            <input type="hidden" name="regarding_type" value="question">

            <?php

            $answered = false;
            $missing = false;
            $answer = false;

            // If this question has already been answered, use the update route instead of creating a new answer
            if(isset($answers[$question->id]))
            {
                $answered = true;
                $answer = $answers[$question->id]->answer;
            }

            ?>

            <div class="profile">
                <div class="row">
                    <div class="col-sm-2 title">Original Question</div>
                    <div class="col-sm-10 value">{{ $question->question }}</div>
                </div>

                <div class="row">
                    <div class="col-sm-2 title">Applicant's Answer</div>
                    <div class="col-sm-10 value">
                        @if($question->type == 'file')
                            @if(isset($answers[$question->id]) && $answers[$question->id]->documents->count())
                                @foreach($answers[$question->id]->documents as $document)
                                    <a class="document" href="/files/user/{{ $document->file }}">{{ $document->name }}</a><br>
                                @endforeach
                            @else
                                No files uploaded.
                            @endif
                        @else
                            {!! nl2br(e($answer)) !!}
                        @endif
                    </div>
                </div>
            </div>
        @endif

        @include('partials/form/text', ['name' => 'message', 'label' => 'Your Question', 'placeholder' => "What would you like to know?", 'limit' => 255])

        @include('partials/form/select',
        [
            'name' => 'type',
            'label' => 'Type of Answer',
            'class' => 'answer-type',
            'options' =>
            [
                'text' => "Paragraph",
                'input' => "Short Sentence",
                'dropdown' => "Multiple Choice",
                'boolean' => "Yes / No",
//                'file' => "File Upload",
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
        <a href="/applications/{{ $application->id }}/review" class="btn btn-danger">Cancel Request</a>
    {!! Form::close() !!}
@endsection

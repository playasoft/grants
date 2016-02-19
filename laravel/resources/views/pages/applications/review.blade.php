@extends('app')

@section('content')
    <h1>
        @if($application->status == 'new')
            Review Before Submitting
        @else
            Review Submitted Application
        @endif
    </h1>
    
    <hr>

    @can('view-submitted-application')
        <h2>User Information</h2>

        <div class="profile">
            <div class="row">
                <div class="col-sm-2 title">Username</div>
                <div class="col-sm-10 value">{{ $application->user->name }}</div>
            </div>

            <div class="row">
                <div class="col-sm-2 title">Email</div>
                <div class="col-sm-10 value">{{ $application->user->email }}</div>
            </div>
        </div>
        
        <hr>
    @endcan

    <h2>Project Information</h2>

    <table class="table table-hover">
        <thead>
            <tr>
                <th>Question</th>
                <th>Answer</th>

                @cannot('rate-answer')
                    <th class="button">Required</th>
                @endcannot
            </tr>
        </thead>

        <tbody>
            <tr>
                <td><b>Name of Your Project</b></td>
                <td>{{ $application->name }}</td>

                @cannot('rate-answer')
                    <td class="button"><span class="success glyphicon glyphicon-ok"></span></td>
                @endcannot
            </tr>

            <tr>
                <td><b>Basic Description</b></td>
                <td>{!! nl2br(e($application->description)) !!}</td>

                @cannot('rate-answer')
                    <td class="button"><span class="success glyphicon glyphicon-ok"></span></td>
                @endcannot
            </tr>
        </tbody>
    </table>

    <hr>

    @can('rate-answer')
        <h2>Questions About This Project</h2>
    @else
        <h2>Questions About Your Project</h2>
    @endcan
    
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Question</th>
                <th>Answer</th>

                @can('rate-answer')
                    <th>Rating</th>
                    <th>&nbsp;</th>
                @else
                    <th class="button">Required</th>
                @endcan
            </tr>
        </thead>

        <tbody>
            @foreach($questions['user'] as $question)
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

                // If this question is required
                if($question->required)
                {
                    // If the answer is empty, or the type is file and there are no uploaded documents
                    if(empty($answer) || $question->type == 'file' && !$answers[$question->id]->documents->count())
                    {
                        $missing = true;
                        $answer = "Your answer is missing.";
                   }
                }

                ?>

                <tr class="{{ ($missing) ? 'danger' : '' }}">
                    <td><b>{{ $question->question }}</b></td>
                    <td>
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
                    </td>

                    @can('rate-answer')
                        <td>
                            Not Rated
                        </td>
                    
                        <td>
                            @if($answered && !$missing)
                                <a href="/answer/{{ $answers[$question->id]->id }}/rate" class="btn btn-primary">Rate Answer</a>
                            @else
                                Not Answered
                            @endif
                        </td>
                    @else
                        <td class="button">
                            @if($question->required)
                                <span class="{{ ($missing) ? 'error' : 'success' }} glyphicon glyphicon-ok"></span>
                            @endif
                        </td>
                    @endcan
                </tr>
            @endforeach
        </tbody>
    </table>

    @can('view-submitted-application')
        <hr>
        
        <h2>Questions for Judges</h2>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Rating</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>

            <tbody>
                @foreach($questions['judge'] as $question)
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

                    // If this question is required
                    if($question->required)
                    {
                        // If the answer is empty, or the type is file and there are no uploaded documents
                        if(empty($answer) || $question->type == 'file' && !$answers[$question->id]->documents->count())
                        {
                            $missing = true;
                            $answer = "Your answer is missing.";
                       }
                    }

                    ?>

                    <tr class="{{ ($missing) ? 'danger' : '' }}">
                        <td><b>{{ $question->question }}</b></td>
                        <td>
                            @if($question->type == 'file')
                                @if(isset($answers[$question->id]) && $answers[$question->id]->documents->count())
                                    @foreach($answers[$question->id]->documents as $document)
                                        <a class="document" href="/files/user/{{ $document->file }}">{{ $document->name }}</a><br>
                                    @endforeach
                                @endif
                            @else
                                @if($answer)
                                    {!! nl2br(e($answer)) !!}
                                @else
                                    <a href="/applications/{{ $application->id }}" class="btn btn-success">Answer Question</a>
                                @endif
                            @endif
                        </td>

                        <td>
                            @if($answer)
                                Not Rated
                            @else
                                Not Answered
                            @endif
                        </td>

                        <td>
                            @if($answered && !$missing)
                                <a href="/answer/{{ $answers[$question->id]->id }}/rate" class="btn btn-primary">Rate Answer</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endcan
    
    @if($application->status == 'new')
        {!! Form::open(['url' => "applications/{$application->id}/submit"]) !!}
            <p>
                <b>
                    Warning! After submitting your application, you will not be able to make changes to your answers.
                    Please make sure everything is accurate before submitting.
                </b>
            </p>

            <p>
                When your application is reviewed, you may be contacted with follow-up questions.
            </p>

            <a href="/applications/{{ $application->id }}" class="btn btn-primary">Make Changes</a>
            <button type="submit" class="btn btn-success">Submit Application</button>
        {!! Form::close() !!}
    @endif
@endsection

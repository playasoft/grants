@extends('app')

@section('content')
    <h1>Edit Your Application</h1>
    <hr>

    <h2>Basic Information</h2>
    {!! Form::open(['class' => 'ajax']) !!}
        @include('partials/form/text',
        [
            'name' => 'name',
            'label' => 'Name of Your Project',
            'placeholder' => "Blinky Sparkle Pony",
            'value' => $application->name
        ])

        @include('partials/form/textarea',
        [
            'name' => 'description',
            'label' => 'Basic Description',
            'placeholder' => "We are creating an interactive life size anamatronic pony you can climb inside of and really learn what it's like to be equine. Also the whole thing is covered in blinky lights. You've probably never seen this many LEDs in your life!",
            'value' => $application->description
        ])
    {!! Form::close() !!}

    <hr>

    <h2>Questions About Your Project</h2>

    @foreach($questions as $question)
        <?php

        // Default to the 'answers' route
        $action = 'answers';
        $answer = false;

        // If this question has already been answered, use the update route instead of creating a new answer
        if(isset($answers[$question->id]))
        {
            $action = 'answers/' . $answers[$question->id]->id;
            $answer = $answers[$question->id]->answer;
        }

        ?>
        @if($question->type != 'file')
            {!! Form::open(['url' => $action, 'class' => 'ajax']) !!}
                <input type="hidden" name="application_id" value="{{ $application->id }}">
                <input type="hidden" name="question_id" value="{{ $question->id }}">

                <div class="form-group">
                    <label class="control-label" for="{{ $question->id }}-answer">{{ $question->question }}</label>
                    <span class="pull-right"><span class="status"></span></span>
                    @if($question->type == 'input')
                        <input type="text" name="answer" class="form-control" id="{{ $question->id }}-answer" value="{{ $answer }}">
                    @elseif($question->type == 'text')
                        <textarea name="answer" class="form-control" id="{{ $question->id }}-answer">{{ $answer }}</textarea>
                    @elseif($question->type == 'boolean')
                        <div class="radio">
                            <label>
                                <input type="radio" name="answer" value="yes" id="{{ $question->id }}-answer" {{ ($answer == 'yes') ? 'checked' : '' }}> Yes
                            </label>
                            <br>
                            <label>
                                <input type="radio" name="answer" value="no" id="{{ $question->id }}-answer" {{ ($answer == 'no') ? 'checked' : '' }}> No
                            </label>
                        </div>
                    @elseif($question->type == 'dropdown')
                        <select class="form-control" name="answer" id="{{ $question->id }}-answer">
                            <option value="">----</option>

                            @foreach($question->dropdown() as $value => $option)
                                <option value="{{ $value }}" {{ ($answer == $value) ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach
                        </select>
                    @endif
                    <p>
                        {!! nl2br(e($question->help)) !!}
                    </p>
                </div>
            {!! Form::close() !!}
        @else
            {!! Form::open(['url' => $action, 'files' => true,]) !!}
                <input type="hidden" name="application_id" value="{{ $application->id }}">
                <input type="hidden" name="question_id" value="{{ $question->id }}">
                <input type="hidden" name="answer" value="1">

                <div class="form-group">
                    <label class="control-label" for="{{ $question->id }}-answer">{{ $question->question }}</label>
                    <span class="pull-right"><span class="status"></span></span>
                    @if($answers[$question->id]->documents->count())
                        <div>
                            <ul class="documents">
                                @foreach($answers[$question->id]->documents as $document)
                                    <li>
                                        <a class="document" href="/files/user/{{ $document->file }}">{{ $document->name }}</a>
                                        <a href="/documents/{{ $document->id }}/delete" class="btn btn-danger">Delete</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div>
                        <span class="btn btn-primary btn-file">
                            <input type="file" name="document">
                            <button type="submit" class="btn btn-success">Upload</button>
                        </span>
                    </div>
                    <p>
                        {!! nl2br(e($question->help)) !!}
                    </p>
                </div>
            {!! Form::close() !!}
        @endif
        <hr>
    @endforeach

    <h2>Application Files</h2>
    <p>
        Upload any additional application files; drawings, plans, photos, past projects, etc.
    </p>

    {!! Form::open(['url' => '/documents/' . $application->id . '/add', 'files' => true,]) !!}
        @if($application->documents->count())
            <div>
                <ul class="documents">
                    @foreach($application->documents as $document)
                        <li>
                            <a class="document" href="/files/user/{{ $document->file }}">{{ $document->name }}</a>
                            <a href="/documents/{{ $document->id }}/delete" class="btn btn-danger">Delete</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div>
            <span class="btn btn-primary btn-file">
                <input type="file" name="document">
                <button type="submit" class="btn btn-success">Upload</button>
            </span>
        </div>
    {!! Form::close() !!}
    <hr>

    <a href="/applications/{{ $application->id }}/review" class="btn btn-success">Submit Application</a>
@endsection

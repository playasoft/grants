@extends('app')

@section('content')
    <h1>Viewing Application</h1>
    <hr>

    <h2>Basic Information</h2>
    {!! Form::open() !!}
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

        <button type="submit" class="btn btn-primary">Save Basic Info</button>
    {!! Form::close() !!}

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
    
        {!! Form::open(['url' => $action, 'files' => true]) !!}
            <input type="hidden" name="application_id" value="{{ $application->id }}">
            <input type="hidden" name="question_id" value="{{ $question->id }}">

            <div class="form-group">
                <label class="control-label" for="{{ $question->id }}-answer">{{ $question->question }}</label>

                @if($question->type == 'input')
                    <input type="text" name="answer" class="form-control" id="{{ $question->id }}-answer" value="{{ $answer }}">
                @elseif($question->type == 'text')
                    <textarea name="answer" class="form-control" id="{{ $question->id }}-answer">{{ $answer }}</textarea>
                @elseif($question->type == 'boolean')
                    <div class="radio">
                        <label>
                            <input type="radio" name="answer" value="1" id="{{ $question->id }}-answer" {{ ($answer) ? 'checked' : '' }}> Yes
                        </label>
                        <br>
                        <label>
                            <input type="radio" name="answer" value="0" id="{{ $question->id }}-answer" {{ (!$answer) ? 'checked' : '' }}> No
                        </label>
                    </div>
                @elseif($question->type == 'dropdown')
                    <select class="form-control" name="answer" id="{{ $question->id }}-answer">
                        <option value="">----</option>
                        
                        @foreach($question->dropdown() as $value => $option)
                            <option value="{{ $value }}" {{ ($answer == $value) ? 'selected' : '' }}>{{ $option }}</option>
                        @endforeach
                    </select>
                @elseif($question->type == 'file')
                    <input type="hidden" name="answer" value="1">
                
                    <div>
                        <span class="btn btn-primary btn-file">
                            <input type="file" name="document" id="{{ $question->id }}-answer">
                        </span>
                    </div>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Save Answer</button>
        {!! Form::close() !!}

        <hr>
    @endforeach

    <button type="submit" class="btn btn-success">Submit Application</button>
@endsection

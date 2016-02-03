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
        {!! Form::open(['url' => 'answers']) !!}
            <input type="hidden" name="application_id" value="{{ $application->id }}">
            <input type="hidden" name="question_id" value="{{ $question->id }}">

            <div class="form-group">
                <label class="control-label" for="{{ $question->id }}-answer">{{ $question->question }}</label>

                @if($question->type == 'input')
                    <input type="text" name="answer" class="form-control" id="{{ $question->id }}-answer">
                @elseif($question->type == 'text')
                    <textarea name="answer" class="form-control" id="{{ $question->id }}-answer"></textarea>
                @elseif($question->type == 'boolean')
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="answer" value="1" id="{{ $question->id }}-answer"> Yes
                        </label>
                    </div>
                @elseif($question->type == 'dropdown')
                    <div>
                        // todo
                    </div>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Save Answer</button>
        {!! Form::close() !!}

        <hr>
    @endforeach

    <button type="submit" class="btn btn-success">Submit Application</button>
@endsection

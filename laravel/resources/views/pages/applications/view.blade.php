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
        @include('partials/applications/question-form')
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

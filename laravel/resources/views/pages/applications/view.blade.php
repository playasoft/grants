@extends('app')

@section('content')
    @include('partials/applications/round-ending-notification')

    <h1>Edit Your Application</h1>
    <p>Problem? Email <a href="mailto:grants@apogaea.com">grants@apogaea.com</a>!</p>
    <hr>

    <h3>Recomended Reading</h3>
    <ul>
        <li><a href="http://apogaea.com/art-installations/creativegrants/#FAQ">21 hints for writing a winning grant application.</a>
             (PRO TIP: Pay attention to <a href="http://apogaea.com/art-installations/creativegrants/#Ques19">#19</a>
                  and <a href="http://apogaea.com/art-installations/creativegrants/#Ques21">#21</a>in particular!)
        </li>
    </ul>
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

        @include('partials/form/text',
        [
            'name' => 'budget',
            'label' => 'Requested funds',
            'placeholder' => "$1337",
            'help' => "The maximum amount your project needs",
            'value' => '$' . $application->budget
        ])
    {!! Form::close() !!}

    <hr>

    <h2>Project Details</h2>
    <p>
        Specific details regarding your project. Note the details below each question.
        Refer to the tips at the top of the page,
    </p>
    <br>

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
            </span>

            <button type="submit" class="btn btn-success">Upload</button>
        </div>

        <p>
            Note: Maximum upload size is <?php echo ini_get('upload_max_filesize'); ?>B per file
        </p>
    {!! Form::close() !!}
    <hr>

    @if($application->round->status() == 'ongoing')
        Next Step: Review your application prior to submission. <br>
        <a href="/applications/{{ $application->id }}/review" class="btn btn-success">Review Application</a>
    @endif
@endsection

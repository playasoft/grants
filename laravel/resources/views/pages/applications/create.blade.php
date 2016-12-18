@extends('app')

@section('content')
    <h1>Apply for a Grant</h1>
    <hr>

    <p>
        First things first, we'll need to get some basic information about your application.
        Once you've filled this out, you'll be able to answer more in-depth questions.
    </p>

    {!! Form::open(['url' => 'applications']) !!}
        @include('partials/form/text', ['name' => 'name', 'label' => 'Name of Your Project', 'placeholder' => "Blinky Sparkle Pony"])
        @include('partials/form/textarea', ['name' => 'description', 'label' => 'Basic Description', 'placeholder' => "We are creating an interactive life size anamatronic pony you can climb inside of and really learn what it's like to be equine. Also the whole thing is covered in blinky lights. You've probably never seen this many LEDs in your life!"])
        @include('partials/form/text', ['name' => 'budget', 'label' => 'Budget', 'placeholder' => "$1337", 'help' => "Enter the maximum amount of your request. You'll be asked to provide an itemized list in the next step"])

        <button type="submit" class="btn btn-primary">Continue</button>
    {!! Form::close() !!}
@endsection

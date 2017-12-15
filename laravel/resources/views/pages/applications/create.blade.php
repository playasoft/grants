@extends('app')

@section('content')
    <h1>Apply for a Grant</h1>
    <hr>

    <h2>Before You Start</h2>
    <p>
        <a href="http://apogaea.com/art-installations/creativegrants/#apply">
            REQUIRED READING FOR WRITING A WINNING GRANT (click here before creating your application)
        </a>
    </p>

    <h2>Basic Information</h2>
    <p>
        First things first, we need to get some basic information about your application.
        Once you've filled this out, you'll be asked to answer more in-depth questions.
    </p>

    <p>
        This is your opportunity to tell us about your project in general terms.
        What is the big picture?
        What is your inspiration for creating this?
        What do you want to accomplish and why?
        We have WAY more requests for money than we have money to give out.
        Help us understand what sets your project apart from the other applications we receive, and show us you have put thought into what challenges you may encounter.
    </p>

    <p>
        CATS will score your response using the following criteria:
    </p>

    <ul>
        <li>Is the idea aesthetically pleasing?</li>
        <li>Is the idea novel/unique?</li>
        <li>Is the idea interactive and engages the event population?</li>
        <li>Does the idea evoke an emotional response?</li>
        <li>Does the idea inspire reflection upon self, community, and/or environment?</lis>
        <li>Are images, videos, or other examples of the proposed project provided?</li>
        <li>Do you have video proposal? (Under 2 minutes please. Link to youtube, vimeo, upload video from your phone)</li>
    </ul>

    <hr>

    {!! Form::open(['url' => 'applications']) !!}
        @include('partials/form/text', ['name' => 'name', 'label' => 'Name of Your Project', 'placeholder' => "Blinky Sparkle Pony"])
        @include('partials/form/textarea', ['name' => 'description', 'label' => 'Basic Description', 'placeholder' => "We are creating an interactive life size anamatronic pony you can climb inside of and really learn what it's like to be equine. Also the whole thing is covered in blinky lights. You've probably never seen this many LEDs in your life!"])
        @include('partials/form/text', ['name' => 'budget', 'label' => 'Requested funds', 'placeholder' => "$1337", 'help' => "Enter the maximum amount of funding your project needs. Don't worry if it's only a rough estimate, you can update this amount later. You'll be asked to provide an itemized list in the next step"])

        <button type="submit" class="btn btn-primary">Continue</button>
    {!! Form::close() !!}
@endsection

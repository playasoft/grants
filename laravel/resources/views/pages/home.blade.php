<?php

// If there are any currently ongoing grant rounds, display information about the first one on the home page
if($ongoing->count())
{
    $featured = $ongoing->first();
}
elseif($upcoming->count())
{
    $featured = $upcoming->first();
}

?>

@extends('app')

@section('content')
    @if(env('GLOBAL_NOTICE'))
        <div class="general-alert alert alert-info" role="alert">
            {!! env('GLOBAL_NOTICE') !!}
        </div>
    @endif

    <div class="jumbotron">
        <h1>Apogaea Art Grant Application System</h1>
        <p>
            This is <b>Weightlifter</b>, the online Art Grant Application system for Apogaea. Want to make an art project for Apogaea but worried about the cost? We'll lift that weight off your shoulders!
        </p>

        @if(!empty($featured))
            <h1>{{ $featured->name }}</h1>

            <p>
                This round is open from <b>{{ Carbon\Carbon::createFromFormat("Y-m-d", $featured->start_date)->format('F j, Y') }} to {{ Carbon\Carbon::createFromFormat("Y-m-d", $featured->end_date)->format('F j, Y') }}</b>.
            </p>

            <p>
                {{ $featured->description }}
            </p>
        @else
            <p>
                <b>Grant applications are featuredly closed.</b>
                You may register for an account or log into your existing account, but no new applications can be created at this time.
            </p>
        @endif

        <p>
            If you have problems or questions, please contact <a href="mailto:grants@apogaea.com">grants@apogaea.com</a></br>
            &emsp;&mdash; <a href="http://apogaea.com/about/the-organization/art-department/">CATS</a> of Apogaea.
        </p>

        <hr>

        <p>
            <a class="btn btn-primary btn-lg" href="/about" role="button">Learn More</a>
            <a class="btn btn-success btn-lg" href="/register" role="button">Register an Account</a>
            <a class="btn btn-success btn-lg" href="/login" role="button">Login</a>
        </p>
    </div>
@endsection

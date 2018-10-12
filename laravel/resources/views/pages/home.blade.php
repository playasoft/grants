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

        @if($featured->count())
            @foreach($featured as $round)
                <hr>
                <h2>{{ $round->name }}</h2>

                <p>
                    This round is open from <b>{{ Carbon\Carbon::createFromFormat("Y-m-d", $round->start_date)->format('F j, Y') }} to {{ Carbon\Carbon::createFromFormat("Y-m-d", $round->end_date)->format('F j, Y') }}</b>.
                </p>

                <p>
                    {{ $round->description }}
                </p>
            @endforeach
        @else
            <p>
                <b>Grant applications are currently closed.</b>
                You may register for an account or log into your existing account, but no new applications can be created at this time.
            </p>
        @endif

        <hr>

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

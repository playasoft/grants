@extends('app')

@section('content')
    <div class="jumbotron">
        <h1>Apogaea Art Grant Application System</h1>
        <h2>Welcome!</h2>
        <p>
            This is <b>Weightlifter</b>, the online Apogaea Art Grant Application system.
        </p>

        <h1>2016 Seed Round</h1>
        <p>
            The 2016 Seed Round is open from <b>March 9 to March 21, 2016</b>.
        </p>

        <p>
            Apogaea has allocated $6,000 in art grant awesome-ness this year! This is the only creative grant round we are doing in 2016.  And since we want to spread as much of our seed around as we possibly can on a limited budget, there is a cap of <b>$599 maximum per project</b> for all applications. Please register and fill out an art grant application.
        </p>

        <p>
            If you have problems or questions, please contact <a href="mailto:grants@apogaea.com">grants@apogaea.com</a></br>
            &emsp;&mdash; <a href="http://apogaea.com/about/the-organization/art-department/">CATS</a> of Apogaea.
        </p>

        <hr>

        <p>
            <a class="btn btn-primary btn-lg" href="/about" role="button">Learn More</a>
            <a class="btn btn-success btn-lg" href="/register" role="button">Register an Account</a>
        </p>
    </div>
@endsection

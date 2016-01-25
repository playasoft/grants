@extends('app')

@section('content')
    <div class="jumbotron">
        <h1>Welcome!</h1>
        <p>
            This is <b>Weightlifter</b> an online question and answer system for receiving grant funds.
            This project is based on the requirements defined by CATS of Apogaea.
        </p>

        <p>
            We are currently in <b>open beta</b>!
        </p>

        <p>
            Feel free to register and create an application.
        </p>

        <hr>
        
        <p>
            <a class="btn btn-primary btn-lg" href="/about" role="button">Learn More</a>
            <a class="btn btn-success btn-lg" href="/register" role="button">Register an Account</a>
        </p>
    </div>
@endsection

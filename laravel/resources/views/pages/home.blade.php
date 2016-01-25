@extends('app')

@section('content')
    <div class="jumbotron">
        <h1>Welcome!</h1>
        <p>
            This is <b>Weightlifter</b> an online question and answer system for receiving grant funding from non-profits.
            This project is based on the requirements defined by CATS of Apogaea.
        </p>

        <p>
            We are currently in <b>development</b>!
        </p>

        <p>
            Feel free to register but you may encounter bugs.
        </p>

        <hr>
        
        <p>
            <a class="btn btn-primary btn-lg" href="/about" role="button">Learn More</a>
            <a class="btn btn-success btn-lg" href="/register" role="button">Register an Account</a>
        </p>
    </div>
@endsection

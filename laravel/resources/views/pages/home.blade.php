@extends('app')

@section('content')
	<div class="jumbotron">
		<h1>Welcome!</h1>
		<p>
			This is <b>Weightlifter</b>, the online Apogaea Art Grant Application system.
		</p>

		<p>
			We are currently in <b>development</b>!
		</p>

		<p>
			Feel free to register but you may encounter bugs.
		</p>

		<p>
			If you have problems or questions, please contact <a href="mailto:grants@apogaea.com">grants@apogaea.com</a></br>
			- <a href="http://apogaea.com/about/the-organization/art-department/">CATS</a> of Apogaea.
		</p>

		<hr>

		<p>
			<a class="btn btn-primary btn-lg" href="/about" role="button">Learn More</a>
			<a class="btn btn-success btn-lg" href="/register" role="button">Register an Account</a>
		</p>
	</div>
@endsection

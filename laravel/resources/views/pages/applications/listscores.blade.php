@extends('app')

@section('content')
@can('view-submitted-application')
	<h1>All Applications Scores</h1>
	Average score for each criteria.
	<hr>
	<table class="table table-hover">
		<thead>
			<tr>
			<th>Name</th>
				@foreach($criteria as $criterion)
				<th>C {{ $criterion->id }}</th>
				@endforeach
			</tr>
		</thead>

	    <tbody>
			@foreach($applications as $application)
				<tr>
				<td><a href="/scores/{{ $application->id }}">{{ $application->name }}</a></td>
				@foreach($criteria as $criterion)
					<td>{{ round($appScores[$application->id][$criterion->id], 3) }}</td>
				@endforeach
				</tr>
			@endforeach
	    </tbody>
	</table>

@endcan
@endsection

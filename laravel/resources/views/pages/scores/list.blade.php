@extends('app')

@section('content')
    @can('view-submitted-application')
        <h1>All Applications Scores</h1>
        Average score for each criteria.
        @foreach($rounds as $round)
            <hr>
            <h2> {{ $round->name }} </h2>
            <div class="scrollable">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Total Score</th>
                            <th>Objective Score</th>
                            <th>Subjective Score</th>
                            @foreach($round->criteria as $index => $criterion)
                                <th title="{{ $criterion->question }}">C {{ $index + 1 }}</th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($round->applications()->whereIn('status', ['submitted', 'review', 'accepted', 'rejected'])->orderBy('total_score', 'desc')->get() as $application)
                            <tr>
                                <td><a href="/scores/{{ $application->id }}">{{ $application->name }}</a></td>
                                <td>{{ $application->total_score }}</td>
                                <td>{{ $application->objective_score }}</td>
                                <td>{{ $application->subjective_score }}</td>
                                @foreach($round->criteria as $criterion)
                                    @if(isset($appScores[$application->id][$criterion->id]))
                                        <td>{{ round($appScores[$application->id][$criterion->id], 3) }}</td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
            </div>
        @endforeach
    @endcan
@endsection

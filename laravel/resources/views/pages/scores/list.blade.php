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
                            @foreach($criteria as $criterion)
                                <th title="{{ $criterion->question }}">C {{ $criterion->id }}</th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($applications as $application)
                            @if($application->round_id == $round->id)
                                <tr>
                                <td><a href="/scores/{{ $application->id }}">{{ $application->name }}</a></td>
                                @foreach($criteria as $criterion)
                                    <td>{{ round($appScores[$application->id][$criterion->id], 3) }}</td>
                                @endforeach
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                <br>
            </div>
        @endforeach
    @endcan
@endsection

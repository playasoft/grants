@extends('app')

@section('content')
    <h1>Application Grant Rounds</h1>
    <hr>

    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Budget</th>
                <th>Start Date</th>
                <th>End Date</th>
            </tr>
        </thead>

        <tbody>
            @foreach($rounds as $round)
                <tr>
                    <td><b>{{ $round->id }}</b></td>
                    <td>
                        @can('edit-round')
                            <a href="/rounds/{{ $round->id }}">{{ $round->name }}</a>
                        @else
                            {{ $round->name }}
                        @endcan
                    </td>
                    <td>${{ $round->budget }}</td>
                    <td>{{ $round->start_date }}</td>
                    <td>{{ $round->end_date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @can('create-round')
        <a href="/rounds/create" class="btn btn-primary">Create new Grant Round</a>
    @endcan
@endsection

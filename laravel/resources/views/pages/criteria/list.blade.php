@extends('app')

@section('content')
    <h1>Criteria for Judges</h1>

    @foreach($rounds as $round)
        <hr>
        <h2> {{ $round->name }} </h2>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Question</th>
                    <th>Type</th>
                    <th>Required</th>
                </tr>
            </thead>

            <tbody>
                @foreach($round->criteria as $criteria)
                    <tr>
                        <td>
                            @can('edit-criteria')
                                <a href="/criteria/{{ $criteria->id }}">{{ $criteria->question }}</a></td>
                            @else
                                {{ $criteria->question }}
                            @endcan
                        <td>{{ $criteria->type }}</td>
                        <td>{{ $criteria->required }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

    @can('create-criteria')
        <a href="/criteria/create" class="btn btn-primary">Create new Criteria</a>
    @endcan
@endsection

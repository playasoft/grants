@extends('app')

@section('content')
    <h1>Criteria for Judges</h1>
    <hr>

    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Question</th>
                <th>Type</th>
                <th>Required</th>
            </tr>
        </thead>

        <tbody>
            @foreach($criteria as $criteria)
                <tr>
                    <td><b>{{ $criteria->id }}</b></td>
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

    @can('create-criteria')
        <a href="/criteria/create" class="btn btn-primary">Create new Criteria</a>
    @endcan
@endsection

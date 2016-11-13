@extends('app')

@section('content')
    <h1>Application Grant Rounds</h1>
    <hr>

    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
            </tr>
        </thead>

        <tbody>
            @foreach($rounds as $round)
                <tr>
                    <td><b>{{ $round->id }}</b></td>
                    <td>
                        @can('edit-round')
                            <a href="/rounds/{{ $round->id }}">[todo]</a>
                        @else
                            [todo]
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @can('create-round')
        <a href="/rounds/create" class="btn btn-primary">Create new Grant Round</a>
    @endcan
@endsection

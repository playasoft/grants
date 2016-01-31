@extends('app')

@section('content')
    <h1>All Questions</h1>
    <hr>

    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Question</th>
                <th>Type</th>
                <th>Role</th>
                <th>Status</th>
                <th>Required</th>
            </tr>
        </thead>

        <tbody>
            @foreach($questions as $question)
                <tr>
                    <td><b>{{ $question->id }}</b></td>
                    <td><a href="/questions/{{ $question->id }}">{{ $question->question }}</a></td>
                    <td>{{ $question->type }}</td>
                    <td>{{ $question->role }}</td>
                    <td>{{ $question->status }}</td>
                    <td>{{ $question->required }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @can('create-question')
        <a href="/questions/create" class="btn btn-primary">Create a Question</a>
    @endcan
@endsection

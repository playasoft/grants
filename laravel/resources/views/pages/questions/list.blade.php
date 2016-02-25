@extends('app')

@section('content')
    <h1>Questions for Applicants</h1>
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
            @foreach($questions as $question)
                <tr>
                    <td><b>{{ $question->id }}</b></td>
                    <td>
                        @can('edit-question')
                            <a href="/questions/{{ $question->id }}">{{ $question->question }}</a></td>
                        @else
                            {{ $question->question }}
                        @endcan
                    <td>{{ $question->type }}</td>
                    <td>{{ $question->required }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @can('create-question')
        <a href="/questions/create" class="btn btn-primary">Create a Question</a>
    @endcan
@endsection

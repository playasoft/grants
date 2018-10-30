@extends('app')

@section('content')
    @can('create-question')
        <a href="/questions/create" class="btn btn-primary pull-right">Create a Question</a>
    @endcan

    <h1>Questions for Applicants</h1>

    @foreach($rounds as $round)
        <hr>
        <h2> {{ $round->name }} </h2>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Question</th>
                    <th>Type</th>
                    <th>Required</th>
                    <th>Export</th>
                </tr>
            </thead>

            <tbody>
                @foreach($round->questions as $question)
                    <tr>
                        <td>
                            @can('edit-question')
                                <a href="/questions/{{ $question->id }}">{{ $question->question }}</a></td>
                            @else
                                {{ $question->question }}
                            @endcan
                        <td>{{ $question->type }}</td>
                        <td>{{ $question->required }}</td>
                        <td>{{ $question->export }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

    @can('create-question')
        <a href="/questions/create" class="btn btn-primary">Create a Question</a>
    @endcan
@endsection

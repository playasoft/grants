@extends('app')

@section('content')
    <h1>
        Your Dashboard
        <div class="pull-right" style="font-size:0.4em; margin-top: 1.4em;">User Level: <b>{{ ucfirst(Auth::user()->role) }}</b></div>
    </h1>
    <hr>

    @can('create-question')
        <a href="/questions/create" class="btn btn-primary">Create a Question</a>
    @endcan

    @can('create-application')
        <a href="/applications/create" class="btn btn-primary">Apply for a Grant</a>
    @endcan

    @if($applications->count())
        <h2>Your Applications</h2>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Date Created</th>
                    <th>Date Modified</th>
                </tr>
            </thead>

            <tbody>
                @foreach($applications as $application)
                    <tr>
                        <td><a href="/applications/{{ $application->id }}">{{ $application->name }}</a></td>
                        <td>{{ $application->status }}</td>
                        <td>{{ $application->created_at->format('Y-m-d') }}</td>
                        <td>{{ $application->updated_at->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection

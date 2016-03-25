@extends('app')

@section('content')
    <h1>
        Your Dashboard
        <div class="pull-right" style="font-size:0.4em; margin-top: 1.4em;">User Level: <b>{{ ucfirst(Auth::user()->role) }}</b></div>
    </h1>
    <hr>

    @if($applications->count())
        @if(in_array(Auth::user()->role, ['judge', 'observer']))
            <h2>Applications Requiring Review</h2>
        @else
            <h2>Your Applications</h2>
        @endif

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Last Modified</th>
                </tr>
            </thead>

            <tbody>
                @foreach($applications as $application)
                    <tr>
                        <td>
                            @if($application->status == 'new')
                                <a href="/applications/{{ $application->id }}">{{ $application->name }}</a>
                            @else
                                <a href="/applications/{{ $application->id }}/review">{{ $application->name }}</a>
                            @endif
                        </td>
                        <td>{{ $application->status }}</td>
                        <td>{{ $application->created_at->format('Y-m-d H:i:s e') }}</td>
                        <td>{{ $application->updated_at->format('Y-m-d H:i:s e') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        @if(in_array(Auth::user()->role, ['judge', 'observer']))
            <div class="general-alert alert alert-info" role="alert">
                <b>Nothing Found</b> There are no applications which require review. Either none have been finalized yet, or all applications have already been judged.
            </div>
        @else
            <div class="general-alert alert alert-info" role="alert">
                <b>Hey!</b> You haven't created any applications yet. When you do, they will be listed here.
            </div>
        @endif
    @endif

    @can('create-question')
        <a href="/questions/create" class="btn btn-primary">Create a Question</a>
    @endcan

    @can('create-application')
        @if(env('ALLOW_APPLICATIONS', true))
            <a href="/applications/create" class="btn btn-primary">Apply for a Grant</a>
        @endif
    @endcan

    @can('view-submitted-application')
        <a href="/applications" class="btn btn-primary">View All Submitted Applications</a>
    @endcan
@endsection

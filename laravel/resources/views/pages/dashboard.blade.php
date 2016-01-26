@extends('app')

@section('content')
    <h1>
        Your Dashboard
        <div class="pull-right" style="font-size:0.4em; margin-top: 1.4em;">User Level: <b>{{ ucfirst(Auth::user()->role) }}</b></div>
    </h1>
    <hr>

    @can('create-question')
        <a href="/question/create" class="btn btn-primary">Create a Question</a>
    @endcan

    @can('create-application')
        <a href="/application/create" class="btn btn-primary">Apply for a Grant</a>
    @endcan

@endsection

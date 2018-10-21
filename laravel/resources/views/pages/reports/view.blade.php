<?php

$roundList = [0 => '----'];

foreach($rounds as $round)
{
    $roundList[$round->id] = $round->name;
}

?>
@extends('app')

@section('content')
<div class="report-generator">
	<input type="hidden" class="csrf-token" name="_token" value="{{ csrf_token() }}">

    {!! Form::open(['url' => 'report/generate']) !!}
        <h1>Report Generator</h1>
        <hr>
        @include('partials/form/select',
        [
        	'name' => 'round',
            'label' => 'Round',
            'class' => 'report-event',
            'options' => $roundList
        ])
            

        <button class="btn btn-primary" type="submit" value="Generate Report">Create Report</button>
    {!! Form::close() !!}
 </div>           
 
 
@endsection
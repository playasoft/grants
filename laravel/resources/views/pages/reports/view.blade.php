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
            

        
    {!! Form::close() !!}
 </div>           
 
 <a href="#" ><button class="btn btn-primary">Create Report</button></a>
@endsection
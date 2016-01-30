<?php

if(old($name))
{
    $value = old($name);
}

?>

@extends('partials/form/_bootstrap')

@section('html')
    <select class="form-control {{ $class or '' }}" name="{{ $name }}" id="{{ $name }}-field">
        @foreach($options as $value => $option)
            <option value="{{ $value }}">{{ $option }}</option>
        @endforeach
    </select>
@overwrite

<?php

if(old($name))
{
    $value = old($name);
}

?>

@extends('partials/form/_bootstrap')

@section('html')
    @foreach($options as $option)
        <div class="checkbox">
            <label>
                <input type="checkbox"
                        name="{{ $name }}"
                        id="{{ $name }}-field"
                        placeholder="{{ $placeholder or '' }}"
                        value="{{ $value or '' }}">

                {{ $option }}
            </label>
        </div>
    @endforeach
@overwrite

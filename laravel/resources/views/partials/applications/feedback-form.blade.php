<?php

// Disable form by default unless you're an applicant
$disabled = 'disabled';

if(Auth::user()->role == 'applicant')
{
    $disabled = '';
}

?>

@if($feedback->type == 'file')
    <div class="form-group">
        <label class="control-label" for="{{ $feedback->id }}-answer">{{ $feedback->message }}</label>
        <span class="pull-right"><span class="status"></span></span>

        <p>
            [File Feedback Not Yet Supported]
        </p>
    </div>
@else
    {!! Form::open(['url' => '/feedback/{{ $feedback->id }}', 'class' => 'ajax']) !!}
        <div class="form-group">
            <label class="control-label" for="{{ $feedback->id }}-answer">
                @if($feedback->regarding->exists)
                    @if($feedback->regarding_type == 'question')
                        Feedback regarding your answer to: {{ $feedback->regarding->question }}<br>
                    @endif
                @endif

                {{ $feedback->message }}
            </label>
            <span class="pull-right"><span class="status"></span></span>
            @if($feedback->type == 'input')
                <input type="text" name="answer" class="form-control" id="{{ $feedback->id }}-answer" value="{{ $feedback->response }}" {{ $disabled }}>
            @elseif($feedback->type == 'text')
                <textarea name="answer" class="form-control" id="{{ $feedback->id }}-answer" {{ $disabled }}>{{ $feedback->response }}</textarea>
            @elseif($feedback->type == 'boolean')
                <div class="radio">
                    <label>
                        <input type="radio" name="answer" value="yes" id="{{ $feedback->id }}-answer" {{ ($feedback->response == 'yes') ? 'checked' : '' }} {{ $disabled }}> Yes
                    </label>
                    <br>
                    <label>
                        <input type="radio" name="answer" value="no" id="{{ $feedback->id }}-answer" {{ ($feedback->response == 'no') ? 'checked' : '' }} {{ $disabled }}> No
                    </label>
                </div>
            @elseif($feedback->type == 'dropdown')
                <select class="form-control" name="answer" id="{{ $feedback->id }}-answer" {{ $disabled }}>
                    <option value="">----</option>

                    @foreach($feedback->dropdown() as $value => $option)
                        <option value="{{ $value }}" {{ ($feedback->response == $value) ? 'selected' : '' }}>{{ $option }}</option>
                    @endforeach
                </select>
            @endif
            <p>
                {!! nl2br(e($feedback->help)) !!}
            </p>
        </div>
    {!! Form::close() !!}
@endif

<hr>

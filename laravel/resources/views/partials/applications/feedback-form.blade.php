<?php

// Disable form by default unless you're an applicant
$disabled = 'disabled';
$submit = false;

if(Auth::user()->role == 'applicant')
{
    $disabled = '';
}

?>

@if($application->feedback->count())
    @foreach($application->feedback as $index => $feedback)
        @if($feedback->type == 'file')
            <div class="form-group">
                <label class="control-label" for="{{ $feedback->id }}-response">{{ $feedback->message }}</label>
                <span class="pull-right"><span class="status"></span></span>

                <p>
                    [File Feedback Not Yet Supported]
                </p>
            </div>
        @else
            {!! Form::open(['url' => '/feedback/' . $feedback->id, 'class' => 'ajax']) !!}
                <div class="form-group">
                    @if(($feedback->regarding_type == 'question' && $feedbacktype == 'question') &&
                       (isset($feedback->regarding->question) && $feedback->regarding->question == $question->question) ||
                       ($feedback->regarding_type == 'general' && $feedbacktype == 'general'))

                        <?php $submit = true; ?>
                        <div class="feedback">
                            <label class="control-label" for="{{ $feedback->id }}-response">
                                <div class="title">{{ ucfirst($feedbacktype) }} Follow-up: {{ $feedback->message }} </div>
                            </label>
                            <span class="pull-right"><span class="status"></span></span>
                            @if(Auth::user()->role != 'applicant' && in_array($feedback->type, ['input', 'text']))
                                @if($feedback->response != '')
                                    <p>{!! nl2br(e($feedback->response)) !!}</p>
                                @else
                                    <p>[Applicant has not responded.]</p>
                                @endif
                            @elseif($feedback->type == 'input')
                                <input type="text" name="response" class="form-control" id="{{ $feedback->id }}-response" value="{{ $feedback->response }}" {{ $disabled }}>
                            @elseif($feedback->type == 'text')
                                <textarea name="response" class="form-control" id="{{ $feedback->id }}-response" {{ $disabled }}>{{ $feedback->response }}</textarea>
                            @elseif($feedback->type == 'boolean')
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="response" value="yes" id="{{ $feedback->id }}-response" {{ ($feedback->response == 'yes') ? 'checked' : '' }} {{ $disabled }}> Yes
                                    </label>
                                    <br>
                                    <label>
                                        <input type="radio" name="response" value="no" id="{{ $feedback->id }}-response" {{ ($feedback->response == 'no') ? 'checked' : '' }} {{ $disabled }}> No
                                    </label>
                                </div>
                            @elseif($feedback->type == 'dropdown')
                                <select class="form-control" name="response" id="{{ $feedback->id }}-response" {{ $disabled }}>
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
                    @endif
                </div>
            {!! Form::close() !!}
        @endif
    @endforeach

    @if($submit)
        <div class="submit-answer">
            <button class="btn btn-primary">Submit Answer</button>
            <span class="status success hidden">Answer Saved!</span>
        </div>
    @endif
@endif

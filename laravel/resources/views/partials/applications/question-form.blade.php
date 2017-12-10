<?php

// Default to the 'answers' route
$action = 'answers';
$answer = false;

// If this question has already been answered, use the update route instead of creating a new answer
if(isset($answers[$question->id]))
{
    $action = 'answers/' . $answers[$question->id]->id;
    $answer = $answers[$question->id]->answer;
}

?>

@if($question->type != 'file')
    {!! Form::open(['url' => $action, 'class' => 'ajax']) !!}
        <input type="hidden" name="application_id" value="{{ $application->id }}">
        <input type="hidden" name="question_id" value="{{ $question->id }}">

        <div class="form-group">
            <label class="control-label" for="{{ $question->id }}-answer">{{ $question->question }}</label>
            <span class="pull-right"><span class="status"></span></span>
            @if($question->type == 'input')
                <input type="text" name="answer" class="form-control" id="{{ $question->id }}-answer" value="{{ $answer }}">
            @elseif($question->type == 'text')
                <textarea name="answer" class="form-control" id="{{ $question->id }}-answer">{{ $answer }}</textarea>
            @elseif($question->type == 'boolean')
                <div class="radio">
                    <label>
                        <input type="radio" name="answer" value="yes" id="{{ $question->id }}-answer" {{ ($answer == 'yes') ? 'checked' : '' }}> Yes
                    </label>
                    <br>
                    <label>
                        <input type="radio" name="answer" value="no" id="{{ $question->id }}-answer" {{ ($answer == 'no') ? 'checked' : '' }}> No
                    </label>
                </div>
            @elseif($question->type == 'dropdown')
                <select class="form-control" name="answer" id="{{ $question->id }}-answer">
                    <option value="">----</option>

                    @foreach($question->dropdown() as $value => $option)
                        <option value="{{ $value }}" {{ ($answer == $value) ? 'selected' : '' }}>{{ $option }}</option>
                    @endforeach
                </select>
            @elseif($question->type == 'budget')
                <div class="row">
                    <div class="col-xs-3">
                      Price
                    </div>
                    <div class="col-xs-9">
                      Description
                    </div>
                </div>

                <div class="vue-budget" v-html class="form-group" >
                    <div >
                        <div class="row" v-for="(item,index) in fields">
                            <div class="col-xs-3">
                                <input type="number"  v-on:change='inputChanged' v-model="item.cost">
                            </div>
                             <div class="col-xs-8">
                                <input type="text"  v-on:change='inputChanged' v-model="item.description">
                            </div>
                            <button type="button" v-on:click='removeField(index)'>X</button>
                        </div>
                    </div>

                    <button type="button" v-on:click='addField'> Add field</button>
                    <input name="answer" id="{{ $question->id }}-answer" type="textarea" class="hidden" v-bind:value='outputString'>

                </div>


            @endif
            <p>
                {!! nl2br(e($question->help)) !!}
            </p>
        </div>
    {!! Form::close() !!}
@else
    {!! Form::open(['url' => $action, 'files' => true]) !!}
        <input type="hidden" name="application_id" value="{{ $application->id }}">
        <input type="hidden" name="question_id" value="{{ $question->id }}">
        <input type="hidden" name="answer" value="1">

        <div class="form-group">
            <label class="control-label" for="{{ $question->id }}-answer">{{ $question->question }}</label>
            <span class="pull-right"><span class="status"></span></span>
            @if(isset($answers[$question->id]) && $answers[$question->id]->documents->count())
                <div>
                    <ul class="documents">
                        @foreach($answers[$question->id]->documents as $document)
                            <li>
                                <a class="document" href="/files/user/{{ $document->file }}">{{ $document->name }}</a>
                                <a href="/documents/{{ $document->id }}/delete" class="btn btn-danger">Delete</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div>
                <span class="btn btn-primary btn-file">
                    <input type="file" name="document">
                    <button type="submit" class="btn btn-success">Upload</button>
                </span>
            </div>
            <p>
                {!! nl2br(e($question->help)) !!}
            </p>
        </div>
    {!! Form::close() !!}
@endif

<hr>

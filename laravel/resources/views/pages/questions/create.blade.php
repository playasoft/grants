@extends('app')

@section('content')
    <h1>Create a Question</h1>
    <hr>
    
    {!! Form::open(['url' => 'questions']) !!}
        @include('partials/form/text', ['name' => 'question', 'label' => 'Question', 'placeholder' => "What would you like to know?"])

        <div class="form-group">
            <label class="control-label" for="date-field">Type of Answer</label>
    
            <select class="form-control shift-type" id="date-field">
                <option value="input">Short Sentence</option>
                <option value="text">Paragraph</option>
                <option value="dropdown">Multiple Choice</option>
                <option value="boolean">Yes / No</option>
            </select>
        </div>
        
        <div class="question-options hidden">
            @include('partials/form/textarea',
            [
                'name' => 'options',
                'label' => 'Options',
                'placeholder' => 'value : Text Displayed',
                'help' => "When creating a dropdown, you'll need to provide what values will appear."
            ])
        </div>

        <div class="form-group">
            <label class="control-label" for="date-field">Application Status</label>
    
            <select class="form-control shift-type" id="date-field">
                <option value="new">New</option>
                <option value="submitted">Submitted</option>
                <option value="review">Review</option>
                <option value="follow-up">Follow Up</option>
                <option value="accepted">Accepted</option>
                <option value="rejected">Rejected</option>
            </select>

            <span class="help-block">A user will only see this question when their application has this status.</span>
        </div>

        <div class="form-group">
            <label class="control-label" for="date-field">User Role</label>

            <select class="form-control shift-type" id="date-field">
                <option value="applicant">Applicant</option>
                <option value="judge">Judge</option>
            </select>

            <span class="help-block">A user will only see this question if they have a matching user role.</span>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    {!! Form::close() !!}
@endsection

@extends('app')

@section('content')
    <h1>
        @if($application->status == 'new')
            Review Before Submitting
        @else
            Review Submitted Application
        @endif
         - {{ $application->name }}
    </h1>
    
    <hr>

    @can('view-submitted-application')
        <h2>User Information</h2>

        <div class="profile">
            <div class="row">
                <div class="col-sm-2 title">Username</div>
                <div class="col-sm-10 value">{{ $application->user->name }}</div>
            </div>

            <div class="row">
                <div class="col-sm-2 title">Email</div>
                <div class="col-sm-10 value">{{ $application->user->email }}</div>
            </div>
        </div>
        
        <hr>
    @endcan

    <h2>Project Information</h2>
    @can('view-submitted-application')
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Judge Status</th>
                    <th>Score</th>
                    <th>Created</th>
                    <th>Last Modified</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>{{ $application->status }}</td>
                    <td>{{ $application->judge_status }}</td>
                    <td>{{ $application->objective_score }} / {{ $application->subjective_score }} / {{ $application->total_score }}</td>
                    <td>{{ $application->created_at->format('Y-m-d H:i:s e') }}</td>
                    <td>{{ $application->updated_at->format('Y-m-d H:i:s e') }}</td>
                </tr>
            </tbody>
        </table>
    @endcan
    <hr>

    <table class="table table-hover">
        <thead>
            <tr>
                <th>Question</th>
                <th>Answer</th>
                <th class="button">Required</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td><b>Name of Your Project</b></td>
                <td>{{ $application->name }}</td>
                <td class="button"><span class="success glyphicon glyphicon-ok"></span></td>
            </tr>

            <tr>
                <td><b>Basic Description</b></td>
                <td>{!! nl2br(e($application->description)) !!}</td>
                <td class="button"><span class="success glyphicon glyphicon-ok"></span></td>
            </tr>

            @can('view-submitted-application')
                @if($judged)
                    <tr>
                        <td><b>Objective Score</b></td>
                        <td>{{ $application->objective_score }}</td>
                        <td class="button"></td>
                    </tr>

                    <tr>
                        <td><b>Subjective Score</b></td>
                        <td>{{ $application->subjective_score }}</td>
                        <td class="button"></td>
                    </tr>

                    <tr>
                        <td><b>Total Score</b></td>
                        <td>{{ $application->total_score }}</td>
                        <td class="button"></td>
                    </tr>
                @endif
            @endcan
        </tbody>
    </table>

    <hr>

    @can('view-submitted-application')
        <h2>Questions About This Project</h2>
    @else
        <h2>Questions About Your Project</h2>
    @endcan
    
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Question</th>
                <th>Answer</th>
                <th class="button">Required</th>

                @can('create-feedback')
                    <th>&nbsp;</th>
                @endcan
            </tr>
        </thead>

        <tbody>
            @foreach($questions as $question)
                <?php

                $answered = false;
                $missing = false;
                $answer = false;

                // If this question has already been answered, use the update route instead of creating a new answer
                if(isset($answers[$question->id]))
                {
                    $answered = true;
                    $answer = $answers[$question->id]->answer;
                }

                // If this question is required
                if($question->required)
                {
                    // If the answer is empty, or the type is file and there are no uploaded documents
                    if(empty($answer) || $question->type == 'file' && !$answers[$question->id]->documents->count())
                    {
                        $missing = true;
                        $answer = "Your answer is missing.";
                   }
                }

                ?>

                <tr class="{{ ($missing) ? 'danger' : '' }}">
                    <td><b>{{ $question->question }}</b></td>
                    <td>
                        @if($question->type == 'file')
                            @if(isset($answers[$question->id]) && $answers[$question->id]->documents->count())
                                @foreach($answers[$question->id]->documents as $document)
                                    <a class="document" href="/files/user/{{ $document->file }}">{{ $document->name }}</a><br>
                                @endforeach
                            @else
                                No files uploaded.
                            @endif
                        @else
                            {!! nl2br(e($answer)) !!}
                        @endif
                    </td>

                    <td class="button">
                        @if($question->required)
                            <span class="{{ ($missing) ? 'error' : 'success' }} glyphicon glyphicon-ok"></span>
                        @endif
                    </td>

                    @can('create-feedback')
                        <td>
                            <a href="/applications/{{ $application->id }}/feedback/{{ $question->id }}" class="btn btn-primary">Request Feedback</a>
                        </td>
                    @endcan
                </tr>
            @endforeach
        </tbody>
    </table>

    <hr>
    <h2>Files</h2>
    {!! Form::open(['url' => '/documents/' . $application->id . '/add', 'files' => true,]) !!}
        @if($application->documents->count())
            <div>
                <ul class="documents">
                    @foreach($application->documents as $document)
                        <li>
                            <a class="document" href="/files/user/{{ $document->file }}">{{ $document->name }}</a>
                            <a href="/documents/{{ $document->id }}/delete" class="btn btn-danger">Delete</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            No files uploaded.
        @endif
        <div>
            <span class="btn btn-primary btn-file">
                <input type="file" name="document">
                <button type="submit" class="btn btn-success">Upload</button>
            </span>
        </div>
    {!! Form::close() !!}
    <hr>

    @can('create-feedback')
        <a href="/applications/{{ $application->id }}/feedback" class="btn btn-primary">Request General Feedback</a>
    @endcan

    @if($application->feedback->count())
        <h2>Feedback Requested</h2>

        @foreach($application->feedback as $feedback)
            @include('partials/applications/feedback-form')
        @endforeach
    @endif

    @can('view-submitted-application')
        <hr>
        
        <h2>Questions for Judges</h2>

        <h3>Objective Criteria</h3>

        @foreach($criteria['objective'] as $objective)
            <?php

            $score = false;
            $answer = false;

            // If this question has already been answered, use the update route instead of creating a new answer
            if(isset($scores[$objective->id]))
            {
                $score = $scores[$objective->id]->score;
                $answer = $scores[$objective->id]->answer;
            }

            ?>
        
            {!! Form::open(['url' => '/score', 'class' => 'ajax']) !!}
                <input type="hidden" name="application_id" value="{{ $application->id }}">
                <input type="hidden" name="criteria_id" value="{{ $objective->id }}">

                <div class="form-group">
                    <label class="control-label">{{ $objective->question }}</label>
                    <span class="pull-right"><span class="status"></span></span>

                    <table class="table">
                        <tr>
                            <td>
                                <div class="radio-inline">
                                    <label>
                                        <input type="radio" name="score" value="1" {{ ($score === '1') ? 'checked' : '' }} {{ ($judged) ? 'disabled' : '' }}> Yes
                                    </label>
                                </div>

                                <div class="radio-inline">
                                    <label>
                                        <input type="radio" name="score" value="-1" {{ ($score === '-1') ? 'checked' : '' }} {{ ($judged) ? 'disabled' : '' }}> No
                                    </label>
                                </div>

                                <div class="radio-inline">
                                    <label>
                                        <input type="radio" name="score" value="0" {{ ($score === '0') ? 'checked' : '' }} {{ ($judged) ? 'disabled' : '' }}> N/A
                                    </label>
                                </div>
                            </td>

                            <td>
                                <input type="text" class="form-control" name="answer" placeholder="Explain your rating (optional)" value="{{ $answer or '' }}" {{ ($judged) ? 'disabled' : '' }}>
                            </td>

                            <td class="button" style="width:10%; line-height: 2.5em">
                                @if($objective->required)
                                    <span class="information error">Required</span>
                                @else
                                    <span class="information success">Optional</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            {!! Form::close() !!}
        @endforeach

        <hr>

        <h3>Subjective Criteria</h3>

        @foreach($criteria['subjective'] as $subjective)
            <?php

            $score = false;
            $answer = false;

            // If this question has already been answered, use the update route instead of creating a new answer
            if(isset($scores[$subjective->id]))
            {
                $score = $scores[$subjective->id]->score;
                $answer = $scores[$subjective->id]->answer;
            }

            ?>
        
            {!! Form::open(['url' => '/score', 'class' => 'ajax']) !!}
                <input type="hidden" name="application_id" value="{{ $application->id }}">
                <input type="hidden" name="criteria_id" value="{{ $subjective->id }}">

                <div class="form-group">
                    <label class="control-label">{{ $subjective->question }}</label>
                    <span class="pull-right"><span class="status"></span></span>

                    <table class="table">
                        <tr>
                            <td>
                                <div class="radio-inline">
                                    <label>
                                        <input type="radio" name="score" value="2" {{ ($score === '2') ? 'checked' : '' }} {{ ($judged) ? 'disabled' : '' }}> Very
                                    </label>
                                </div>

                                <div class="radio-inline">
                                    <label>
                                        <input type="radio" name="score" value="1" {{ ($score === '1') ? 'checked' : '' }} {{ ($judged) ? 'disabled' : '' }}> A bit
                                    </label>
                                </div>

                                <div class="radio-inline">
                                    <label>
                                        <input type="radio" name="score" value="0" {{ ($score === '0') ? 'checked' : '' }} {{ ($judged) ? 'disabled' : '' }}> Meh
                                    </label>
                                </div>

                                <div class="radio-inline">
                                    <label>
                                        <input type="radio" name="score" value="-1" {{ ($score === '-1') ? 'checked' : '' }} {{ ($judged) ? 'disabled' : '' }}> Not really
                                    </label>
                                </div>

                                <div class="radio-inline">
                                    <label>
                                        <input type="radio" name="score" value="-2" {{ ($score === '-2') ? 'checked' : '' }} {{ ($judged) ? 'disabled' : '' }}> No
                                    </label>
                                </div>
                            </td>

                            <td>
                                <input type="text" class="form-control" name="answer" placeholder="Explain your rating (optional)" value="{{ $answer or '' }}" {{ ($judged) ? 'disabled' : '' }}>
                            </td>

                            <td class="button" style="width:10%; line-height: 2.5em">
                                @if($subjective->required)
                                    <span class="information error">Required</span>
                                @else
                                    <span class="information success">Optional</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            {!! Form::close() !!}
        @endforeach
    @endcan
    
    @if($application->status == 'new' && env('ALLOW_SUBMISSION', true))
        {!! Form::open(['url' => "applications/{$application->id}/submit"]) !!}
            <p>
                <b>
                    Warning! After submitting your application, you will not be able to make changes to your answers.
                    Please make sure everything is accurate before submitting.
                </b>
            </p>

            <p>
                When your application is reviewed, you may be contacted with follow-up questions.
            </p>

            <a href="/applications/{{ $application->id }}" class="btn btn-primary">Make Changes</a>
            <button type="submit" class="btn btn-success">Submit Application</button>
        {!! Form::close() !!}
    @endif

    @can('score-application')
        @if($judged)
            <p>
                Thanks for your help! (You've already submitted your scores for this applcation.)
            </p>

            <a href="/applications" class="btn btn-primary">View All Applications</a>
        @else
            {!! Form::open(['url' => "applications/{$application->id}/judge"]) !!}
                <p>
                    <b>
                        Warning! After submitting your ratings, you will not be able to make changes to your answers.<br>
                        Please make sure everything is accurate before submitting.
                    </b>
                </p>

                <button type="submit" class="btn btn-success">Submit Ratings</button>
            {!! Form::close() !!}
        @endunless
    @endcan

    @can('approve-application')
        @if($application->judge_status == 'ready')
            <hr>

            <p>
                <b>
                    Warning! Approving or denying an application will notify the user who submitted it.<br>
                    After the application is approved or denied, nobody will be able to submit new scores.
                </b>
            </p>

            {!! Form::open(['url' => "applications/{$application->id}/approve", 'style' => "display: inline-block"]) !!}
                <button type="submit" class="btn btn-success">Approve Application</button>
            {!! Form::close() !!}

            {!! Form::open(['url' => "applications/{$application->id}/deny", 'style' => "display: inline-block"]) !!}
                <button type="submit" class="btn btn-danger">Deny Application</button>
            {!! Form::close() !!}
        @endif
    @endcan
@endsection

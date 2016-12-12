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
                <div class="col-sm-10 value"><a href="/users/{{ $application->user->id }}">{{ $application->user->name }}</a></div>
            </div>

            <div class="row">
                <div class="col-sm-2 title">Email</div>
                <div class="col-sm-10 value">{{ $application->user->email }}</div>
            </div>
        </div>

        <hr>
    @endcan

    <h2>Project Information</h2>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Judge Status</th>
                    <th>Created</th>
                    <th>Last Modified</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>{{ $application->status }}</td>
                    <td>{{ $application->judge_status }}</td>
                    <td>{{ $application->created_at->format('Y-m-d H:i:s e') }}</td>
                    <td>{{ $application->updated_at->format('Y-m-d H:i:s e') }}</td>
                </tr>

            </tbody>
        </table>

        <hr>

        @can('view-submitted-application')
            <h2>Score</h2>
            @if($judged)
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th><b>Objective Score</b></th>
                            <th>Subjective Score</th>
                            <th>Total Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $application->objective_score }}</td>
                            <td>{{ $application->subjective_score }}</td>
                            <td>{{ $application->total_score }}</td>
                        </tr>
                    </tbody>
                </table>
            @else
                Not judged yet.
            @endif
        @endcan
    <hr>

    <div class="row-fluid review">
        <div class="{{ Auth::user()->role == 'applicant' ? 'col-xs-12' : 'col-xs-8 h-scroll' }}">
            @can('view-submitted-application')
                <h2>Project Application </h2>
            @else
                <h2>Your Project Application</h2>
            @endcan
            <div class="title">Project Name</div>
            <div class="title ans">{{ $application->name }}</div>

            <div class="title">Basic Description</div>
            <div class="ans">
                {!! nl2br(e($application->description)) !!}
                <?php $feedbacktype = "general"; ?>
                @include('partials/applications/feedback-form')
            </div>

            @can('create-feedback')
                <a href="/applications/{{ $application->id }}/feedback" class="btn btn-primary">Ask General Question</a>
            @endcan

            <hr>

            @foreach($questions as $question)
                <?php

                $answered = false;
                $missing = false;
                $answer = false;
                $feedbacktype = "question";
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


                <div class="title">{{ $question->question }}</div>
                <div class="ans {{ ($missing) ? 'danger' : '' }}">
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

                    @include('partials/applications/feedback-form')
                </div>

                <div>
                    @can('create-feedback')
                        <a href="/applications/{{ $application->id }}/feedback/{{ $question->id }}" class="btn btn-primary">Ask Question</a>
                    @endcan
                </div>
                <hr>
            @endforeach

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
        </div>

        <div class="{{ Auth::user()->role == 'applicant' ? '' : 'col-xs-4' }} h-scroll">
            @can('view-submitted-application')
                @if($application->round->status() != 'ended')
                    <div class="alert alert-info" role="alert">
                        Please wait until the grant round is over before judging an application.
                    </div>
                @else
                    <h2>Judge {{ Auth::user()->username ?: Auth::user()->name }} Score</h2>

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

                        {!! Form::open(['url' => '/score', 'class' => 'ajax score']) !!}
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
                                                    <input type="radio" name="score" value="1" {{ ($score == '1') ? 'checked' : '' }} {{ ($judged) ? 'disabled' : '' }}> Yes
                                                </label>
                                            </div>

                                            <div class="radio-inline">
                                                <label>
                                                    <input type="radio" name="score" value="-1" {{ ($score == '-1') ? 'checked' : '' }} {{ ($judged) ? 'disabled' : '' }}> No
                                                </label>
                                            </div>

                                            <div class="radio-inline">
                                                <label>
                                                    <input type="radio" name="score" value="0" {{ ($score == '0') ? 'checked' : '' }} {{ ($judged) ? 'disabled' : '' }}> N/A
                                                </label>
                                            </div>
                                        </td>
                                        <td class="button" style="width:10%; line-height: 2.5em">
                                            @if($objective->required)
                                                <span class="information error">Required</span>
                                            @else
                                                <span class="information success">Optional</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control" name="answer" placeholder="Explain your rating (optional)" value="{{ $answer or '' }}" {{ ($judged) ? 'disabled' : '' }}>
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

                        {!! Form::open(['url' => '/score', 'class' => 'ajax score']) !!}
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
                                                    <input type="radio" name="score" value="2" {{ ($score == '2') ? 'checked' : '' }} {{ ($judged) ? 'disabled' : '' }}> Very
                                                </label>
                                            </div>

                                            <div class="radio-inline">
                                                <label>
                                                    <input type="radio" name="score" value="1" {{ ($score == '1') ? 'checked' : '' }} {{ ($judged) ? 'disabled' : '' }}> A bit
                                                </label>
                                            </div>

                                            <div class="radio-inline">
                                                <label>
                                                    <input type="radio" name="score" value="0" {{ ($score == '0') ? 'checked' : '' }} {{ ($judged) ? 'disabled' : '' }}> Meh
                                                </label>
                                            </div>

                                            <div class="radio-inline">
                                                <label>
                                                    <input type="radio" name="score" value="-1" {{ ($score == '-1') ? 'checked' : '' }} {{ ($judged) ? 'disabled' : '' }}> Not really
                                                </label>
                                            </div>

                                            <div class="radio-inline">
                                                <label>
                                                    <input type="radio" name="score" value="-2" {{ ($score == '-2') ? 'checked' : '' }} {{ ($judged) ? 'disabled' : '' }}> No
                                                </label>
                                            </div>
                                        </td>

                                        <td class="button" style="width:10%; line-height: 2.5em">
                                            @if($subjective->required)
                                                <span class="information error">Required</span>
                                            @else
                                                <span class="information success">Optional</span>
                                            @endif
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control" name="answer" placeholder="Explain your rating (optional)" value="{{ $answer or '' }}" {{ ($judged) ? 'disabled' : '' }}>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        {!! Form::close() !!}
                    @endforeach
                @endif
            @endcan
            @can('score-application')
                @if($application->round->status() == 'ended')
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
                @endif
            @endcan
        </div>
        <div class="clearfix visible-xs"></div>
        <div class="col-xs-12">
            @if($application->status == 'new' && $application->round->status() == 'ongoing')
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
        </div>
    </div>
@endsection

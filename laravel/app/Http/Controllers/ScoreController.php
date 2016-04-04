<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Application;
use App\Models\Criteria;
use App\Models\Score;
use App\Models\Judged;
use App\Models\User;

use App\Http\Requests\ScoreRequest;
use Illuminate\Support\Facades\Auth;

class ScoreController extends Controller
{
    // Function to save and update the scores for criteria
    function scoreCriteria(ScoreRequest $request)
    {
        // Check if current user is allowed to score things
        $this->authorize('score-application');

        $input = $request->all();

        $application = Application::find($input['application_id']);
        $criteria = Criteria::find($input['criteria_id']);

        // Make sure the application hasn't been finalized
        if(!in_array($application->judge_status, ['new', 'ready']))
        {
            $request->session()->flash('error', 'This application has already been finalized.');
            return redirect('/applications/' . $application->id . '/review');
        }

        // Make sure this user hasn't already submitted their scores
        $judged = Judged::where(['application_id' => $application->id, 'user_id' => Auth::user()->id])->get()->first();

        if(!empty($judged))
        {
            $request->session()->flash('error', 'You have already judged this application!');
            return redirect('/applications');
        }

        // Check if a score already exists for this criteria
        $score = Score::firstOrNew(['application_id' => $application->id, 'criteria_id' => $criteria->id, 'user_id' => Auth::user()->id]);

        // Add submitted information
        $score->application_id = $application->id;
        $score->criteria_id = $criteria->id;
        $score->user_id = Auth::user()->id;
        $score->score = $input['score'];
        $score->answer = $input['answer'];
        $score->save();

        $request->session()->flash('success', 'Your score has been saved.');
        return redirect('/applications/' . $application->id . '/review');
    }

    function listScores()
    {
        $applications = Application::whereIn('status', ['submitted', 'review'])->get();
        $criteria = Criteria::get();
        $appScores = [[]]; // Store the average scores for each criterion of each application

        foreach($applications as $application)
        {
            $scores = Score::where('scores.application_id', $application->id)->join('judged', function($join)
            {
                $join->on('judged.user_id', '=', 'scores.user_id')->on('judged.application_id', '=', 'scores.application_id');
            })->get();

            foreach($criteria as $criterion)
            {
                $criterionScores = $scores->where('criteria_id', $criterion->id);
                $appScores[$application->id][$criterion->id] = $criterionScores->avg('score');
            }
        }
        return view('pages/applications/listscores', compact('applications', 'criteria', 'appScores'));
    }

    function viewScore(Application $application)
    {
        $criteria = Criteria::get();
        $judges = User::where(['role' => 'judge'])->get();
        $judgeScores = [[]];

        // Select all scores made by each judge
        foreach ($judges as $judge)
        {
            $scores = Score::where('user_id', $judge->id)->get();
            foreach($scores as $score)
            {
                $judgeScores[$judge->id][$score->criteria_id] = $score->score;
            }
        }
        return view('pages/applications/scores', compact('application', 'criteria', 'judges', 'judgeScores'));
    }

    function recalcScores(Request $request)
    {
        $this->authorize('recalculate-scores');

        $applications = Application::whereIn('status', ['submitted', 'review'])->get();

        foreach ($applications as $application)
        {
            Score::calculateTotals($application);
        }

        $request->session()->flash('success', 'Scores Recalculated.');
        return redirect('applications/');
    }
}

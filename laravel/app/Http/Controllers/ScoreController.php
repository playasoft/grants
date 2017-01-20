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
use App\Models\Round;

use App\Http\Requests\ScoreRequest;
use Illuminate\Support\Facades\Auth;

class ScoreController extends Controller
{
    // Function to save and update the scores for criteria
    public function scoreCriteria(ScoreRequest $request)
    {
        // Check if current user is allowed to score things
        $this->authorize('score-application');

        $input = $request->all();

        $application = Application::find($input['application_id']);
        $criteria = Criteria::find($input['criteria_id']);

        if($application->round->status() != 'ended')
        {
            $request->session()->flash('error', 'Please wait until the grant round is over before judging an application.');
            return redirect('/applications/' . $application->id . '/review');
        }

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

    public function listScores()
    {
        $applications = Application::whereIn('status', ['submitted', 'review'])->orderBy('total_score', 'desc')->get();
        $criteria = Criteria::get();
        $appScores = []; // Store the average scores for each criterion of each application

        foreach($applications as $application)
        {
            $scores = Score::where('scores.application_id', $application->id)->join('judged', function($join)
            {
                $join->on('judged.user_id', '=', 'scores.user_id')->on('judged.application_id', '=', 'scores.application_id')->where('judged.status', '!=', 'abstain');
            })->get();

            $criteriaScores = [];

            foreach($scores as $score)
            {
                if(!isset($criteriaScores[$score->criteria_id]))
                {
                    $criteriaScores[$score->criteria_id] = ['average' => 0, 'total' => 0, 'count' => 0];
                }

                $criteriaScores[$score->criteria_id]['count']++;
                $criteriaScores[$score->criteria_id]['total'] += $score->score;
                $criteriaScores[$score->criteria_id]['average'] = $criteriaScores[$score->criteria_id]['total'] / $criteriaScores[$score->criteria_id]['count'];
            }

            foreach($criteria as $criterion)
            {
                if(!isset($criteriaScores[$criterion->id]))
                {
                    $criteriaScores[$criterion->id] = ['average' => 0];
                }

                $appScores[$application->id][$criterion->id] = $criteriaScores[$criterion->id]['average'];
            }
        }

        $rounds = Round::latest()->get();
        return view('pages/scores/list', compact('applications', 'criteria', 'appScores', 'rounds'));
    }

    public function viewScore(Application $application)
    {
        $criteria = Criteria::get();
        $judges = User::where(['role' => 'judge'])->get();
        $judgeScores = [];

        // Select all scores made by each judge
        foreach ($judges as $judge)
        {
            $scores = $application->scores()->where('user_id', $judge->id)->get();
            // Make sure this user hasn't already submitted their scores
            $judged = Judged::where(['application_id' => $application->id, 'user_id' => $judge->id])->get()->first();

            foreach($scores as $score)
            {
                if(empty($judged)) {
                    $judgeScores[$judge->id][$score->criteria_id] = 'NS';
                } elseif($judged->status == 'abstain') {
                    $judgeScores[$judge->id][$score->criteria_id] = 'AB';
                } else {
                    $judgeScores[$judge->id][$score->criteria_id] = $score->score;
                }
            }
        }

        return view('pages/scores/view', compact('application', 'criteria', 'judges', 'judgeScores'));
    }

    public function recalcScores(Request $request)
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

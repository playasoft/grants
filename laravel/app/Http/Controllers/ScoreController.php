<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Application;
use App\Models\Criteria;
use App\Models\Score;
use App\Models\Judged;

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
        $score = Score::firstOrNew(['application_id' => $application->id, 'criteria_id' => $criteria->id]);

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
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Score;

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
        $criteria = Question::find($input['criteria_id']);

        // Check if a score already exists for this criteria
        $score = Score::firstOrNew(['application_id' => $application->id, 'criteria_id' => $criteria->id]);

        // Add submitted information
        $score->application_id = $application->id;
        $score->criteria_id = $criteria->id;
        $score->score = $input['score'];
        $score->answer = $input['answer'];
        $score->save();

        $request->session()->flash('success', 'Your score has been saved.');
        return redirect('/applications/' . $application->id);
    }
}

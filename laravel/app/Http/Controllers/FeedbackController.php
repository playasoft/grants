<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\Application;
use App\Models\Question;
use App\Models\Feedback;

use App\Http\Requests\FeedbackRequest;

class FeedbackController extends Controller
{
    // Function to display a form when creating new feedback
    function createFeedbackForm(Application $application, Question $question)
    {
        // Generate an array of answers based on their associated question ID
        $answers = [];
        
        foreach($application->answers as $answer)
        {
            $answers[$answer->question_id] = $answer;
        }
        
        return view('pages/feedback/create', compact('application', 'question', 'answers'));
    }

    // Function for creating new feedback (post request)
    function createFeedback(FeedbackRequest $request)
    {
        // Double check to make sure the current user is authorized to do this...
        $this->authorize('create-feedback');

        $input = $request->all();

        // Check application ID
        $application = Application::find($input['application_id']);

        // Check regarding ID / type, Note, nothing to be done for 'genereal' feedback
        if($input['regarding_type'] == 'question')
        {
            $regarding = Question::find($input['regarding_id']);
        }
        elseif($input['regarding_type'] == 'document')
        {
            // todo
        }
        
        // Create new feedback
        $feedback = new Feedback;
        $feedback->application_id = $application->id;
        $feedback->regarding_type = $input['regarding_type'];

        if(isset($regarding) && $regarding->exists)
        {
            $feedback->regarding_id = $regarding->id;
        }

        // Set the current judge ID for a record of who requested this feedback
        $feedback->user_id = Auth::user()->id;
        $feedback->save();

        $feedback->update($input);

        // todo: Notify user

        $request->session()->flash('success', 'Your feedback has been requested.');
        return redirect('/applications/' . $application->id . '/review');
    }

    // Function for saving user answers to feedback
    function updateFeedback(Request $request, Feedback $feedback)
    {
        // Does the current user own the application this feedback is in regards to?
        if($feedback->application->user->id != Auth::user()->id)
        {
            $request->session()->flash('error', 'Only the person who created an application may answer feedback for it.');
            return redirect('/login');
        }

        $feedback->response = $request->input('response');
        $feedback->save();

        $request->session()->flash('success', 'Your answer has been saved.');
        return redirect('/applications/' . $feedback->application->id . '/review');
    }
}

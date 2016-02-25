<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Application;
use App\Models\Question;
use App\Models\Criteria;

use App\Http\Requests\ApplicationRequest;

use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function listApplications()
    {
        if($this->auth->check())
        {
            if(in_array($this->auth->user()->role, ['admin']))
            {
                $applications = Application::get();
            }
            elseif(in_array($this->auth->user()->role, ['judge', 'observer']))
            {
                $applications = Application::whereIn('status', ['submitted', 'review'])->get();
            }
            else
            {
                // otherwise redirect to home page? (normal users see a list in their dashboard)
                return redirect('');
            }

            return view('pages/applications/list', compact('applications'));
        }
        else
        {
            return redirect('');
        }

    }

    public function createApplication(ApplicationRequest $request)
    {
        // Double check to make sure the current user is authorized to do this...
        $this->authorize('create-application');

        // Generate a new application, assign required information
        $application = new Application;
        $application->status = "new";
        $application->user_id = Auth::user()->id;
        $application->save();

        // Assign user input
        $input = $request->all();
        $application->update($input);

        $request->session()->flash('success', 'Your application has been created.');
        return redirect('/applications/' . $application->id);
    }

    public function createApplicationForm()
    {
        return view('pages/applications/create');
    }

    public function viewApplication(Application $application, Request $request)
    {
        // Did the current user create this application?
        if($application->user->id != Auth::user()->id)
        {
            // If not, are they authorized to view applications?
            $this->authorize('view-application');
        }

        if($application->status != 'new')
        {
            $request->session()->flash('error', 'Your application has been submitted, you may no longer make changes.');
            return redirect('/applications/' . $application->id . '/review');
        }

        $questions = Question::get();
        
        // Generate an array of answers based on their associated question ID
        $answers = [];

        foreach($application->answers as $answer)
        {
            $answers[$answer->question_id] = $answer;
        }

        return view('pages/applications/view', compact('application', 'questions', 'answers'));
    }

    public function updateApplication(Application $application, ApplicationRequest $request)
    {
        // Did the current user create this application?
        if($application->user->id != Auth::user()->id)
        {
            $request->session()->flash('error', 'Only the person who created an application may change it.');
            return redirect('/login');
        }

        if($application->status != 'new')
        {
            $request->session()->flash('error', 'Your application has been submitted, you may no longer make changes.');
            return redirect('/applications/' . $application->id . '/review');
        }

        $input = $request->all();
        $application->update($input);

        $request->session()->flash('success', 'Your application has been updated.');
        return redirect('/applications/' . $application->id);
    }

    public function reviewApplication(Application $application, Request $request)
    {
        // Did the current user create this application?
        if($application->user->id != Auth::user()->id)
        {
            // If not, are they authorized to view applications?
            if(!(Auth::user()->can('view-application') || (Auth::user()->can('view-submitted-application') && $application->status != 'new')))
            {
                $request->session()->flash('error', 'You are not authorized to view this application.');
                return redirect('/login');
            }
        }

        $questions = Question::get();
        $criteria =
        [
            'objective' => Criteria::where('type', 'objective')->get(),
            'subjective' => Criteria::where('type', 'subjective')->get(),
        ];
        
        // Generate an array of answers based on their associated question ID
        $answers = [];
        
        foreach($application->answers as $answer)
        {
            $answers[$answer->question_id] = $answer;
        }

        $scores = [];

        // Select all scores made by the current user
        foreach($application->scores()->where('user_id', Auth::user()->id)->get() as $score)
        {
            $scores[$score->criteria_id] = $score;
        }

        return view('pages/applications/review', compact('application', 'questions', 'answers', 'criteria', 'scores'));
    }

    // Helper function for checking if all required answers are filled in
    private function missingRequiredAnswers($application)
    {
        // Generate an array of answers based on their associated question ID
        $answers = [];

        foreach($application->answers as $answer)
        {
            $answers[$answer->question_id] = $answer;
        }

        // Loop through all required questions
        $questions = Question::where('required', 1)->get();

        foreach($questions as $question)
        {
            if(!isset($answers[$question->id]))
                return true;

            if(empty($answers[$question->id]->answer))
                return true;
        }

        return false;
    }

    public function submitApplication(Application $application, Request $request)
    {
        // Did the current user create this application?
        if($application->user->id != Auth::user()->id)
        {
            $request->session()->flash('error', 'Only the person who created an application may submit it.');
            return redirect('/login');
        }

        if($this->missingRequiredAnswers($application))
        {
            $request->session()->flash('error', 'Your application is missing required information.');
            return redirect('/applications/' . $application->id . '/review');
        }

        if($application->status != 'new')
        {
            $request->session()->flash('error', 'Your application has been submitted, you may no longer make changes.');
            return redirect('/applications/' . $application->id . '/review');
        }

        $application->status = 'submitted';
        $application->save();

        $request->session()->flash('success', 'Thank you, your application has been submitted and will be reviewed by our judges.');
        return redirect('/');
    }
}

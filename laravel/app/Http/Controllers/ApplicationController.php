<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Application;
use App\Models\Question;

use App\Http\Requests\ApplicationRequest;

use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function listApplications()
    {
        // check user role
        // display all applicaitons if admin
        // otherwise redirect to home page? (normal users see a list in their dashboard)

        return view('pages/applications/list');
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

        $request->session()->flash('success', 'Your question has been created.');
        return redirect('/applications/' . $application->id);
    }

    public function createApplicationForm()
    {
        return view('pages/applications/create');
    }

    public function viewApplication(Application $application)
    {
        // Did the current user create this application?
        if($application->user->id != Auth::user()->id)
        {
            // If not, are they authorized to view applications?
            $this->authorize('view-application');
        }

        // Select questions based on the status of the application
        $questions = Question::where('status', $application->status)->get();

        return view('pages/applications/view', compact('application', 'questions'));
    }
}

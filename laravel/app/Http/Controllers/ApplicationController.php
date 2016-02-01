<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Application;
use App\Http\Requests\ApplicationRequest;

use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function listApplications()
    {
        // check user role
        // display all applicaitons if admin
        // otherwise only display your own

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

    public function viewApplication()
    {
        return "// view a single application";
    }
}

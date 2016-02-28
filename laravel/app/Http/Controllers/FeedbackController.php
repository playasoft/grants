<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Application;
use App\Models\Question;

class FeedbackController extends Controller
{
    // Function to display a form when creating new feedback
    function createFeedbackForm(Application $application, Question $question)
    {
        return view('pages/feedback/create', compact('application', 'question'));
    }

    // Function for creating new feedback (post request)
    function createFeedback()
    {
        // Double check to make sure the current user is authorized to do this...
        $this->authorize('create-feedback');

        return "// todo";
    }
}

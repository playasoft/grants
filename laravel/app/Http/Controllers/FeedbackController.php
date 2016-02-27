<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class FeedbackController extends Controller
{
    // Function to display a form when creating new feedback
    function createFeedbackForm()
    {
        return "Hi there!";
    }

    // Function for creating new feedback (post request)
    function createFeedback()
    {
        return "Todo";
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    function listQuestions()
    {
        return "[Insert list here]";
    }

    function postQuestion()
    {
        return "Almost!";
    }

    function createQuestionForm()
    {
        return view('pages/questions/create');
    }
}

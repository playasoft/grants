<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\QuestionRequest;


class QuestionController extends Controller
{
    function listQuestions()
    {
        return "[Insert list here]";
    }

    function postQuestion(QuestionRequest $request)
    {
        return "Almost!";
    }

    function createQuestionForm()
    {
        return view('pages/questions/create');
    }
}

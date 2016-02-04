<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Application;
use App\Models\Question;
use App\Models\Answer;

use App\Http\Requests\AnswerRequest;


class AnswerController extends Controller
{
    public function createAnswer(AnswerRequest $request)
    {
        return "// todo";
    }

    public function updateAnswer(AnswerRequest $request, Answer $answer)
    {
        return "// todo";
    }
}

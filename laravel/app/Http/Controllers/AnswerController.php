<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Application;
use App\Models\Question;
use App\Models\Answer;

use App\Http\Requests\AnswerRequest;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    public function createAnswer(AnswerRequest $request)
    {
        // Check if current user created this application
        $input = $request->all();

        $application = Application::find($input['application_id']);
        $question = Question::find($input['question_id']);

        if($application->user->id != Auth::user()->id)
        {
            $request->session()->flash('error', 'Only the person who created an application may answer questions for it.');
            return redirect('/login');
        }

        $answer = new Answer;
        $answer->application_id = $application->id;
        $answer->question_id = $question->id;
        $answer->answer = $input['answer'];
        $answer->save();

        $request->session()->flash('success', 'Your answer has been saved.');
        return redirect('/applications/' . $application->id);
    }

    public function updateAnswer(AnswerRequest $request, Answer $answer)
    {
        if($answer->user->id != Auth::user()->id)
        {
            $request->session()->flash('error', 'Only the person who created an application may answer questions for it.');
            return redirect('/login');
        }

        $input = $request->all();
        $answer->update($input);

        $request->session()->flash('success', 'Your answer has been saved.');
        return redirect('/applications/' . $answer->application->id);
    }
}

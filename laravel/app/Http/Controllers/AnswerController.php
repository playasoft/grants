<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Application;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Document;

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

        if($application->status != 'new')
        {
            $request->session()->flash('error', 'Your application has been submitted, you may no longer make changes.');
            return redirect('/applications/' . $application->id . '/review');
        }

        // Check if an answer already exists for this question
        $answer = Answer::firstOrNew(['application_id' => $application->id, 'question_id' => $question->id]);

        // Add submitted information
        $answer->application_id = $application->id;
        $answer->question_id = $question->id;
        $answer->answer = $input['answer'];
        $answer->save();

        // Check if a file needs to be uploaded
        if($question->type == 'file')
        {
            // Save uploaded file
            $upload = Document::handleUpload($request);

            // Save new document
            Document::createDocument($application, $upload, $answer);
        }

        $request->session()->flash('success', 'Your answer has been saved.');
        return redirect('/applications/' . $application->id);
    }

    public function updateAnswer(AnswerRequest $request, Answer $answer)
    {
        $input = $request->all();
        $application = Application::find($input['application_id']);

        if($answer->user->id != Auth::user()->id)
        {
            $request->session()->flash('error', 'Only the person who created an application may answer questions for it.');
            return redirect('/login');
        }

        if($answer->application->status != 'new')
        {
            $request->session()->flash('error', 'Your application has been submitted, you may no longer make changes.');
            return redirect('/applications/' . $application->id . '/review');
        }

        $answer->update($input);

        // Check if a file needs to be uploaded
        if($answer->question->type == 'file')
        {
            // Save uploaded file
            $upload = Document::handleUpload($request);

            // Save new document
            Document::createDocument($application, $upload, $answer);
        }

        $request->session()->flash('success', 'Your answer has been saved.');
        return redirect('/applications/' . $answer->application->id);
    }
}

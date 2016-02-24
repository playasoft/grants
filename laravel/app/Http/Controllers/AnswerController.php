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
    // Private function to manage file uploads
    private function handleUpload($request)
    {
        $fileName = false;
        
        // Save event image with a unique name
        if($request->hasFile('document'))
        {
            // Create upload folder if it doesn't exist
            if(!file_exists(public_path() . '/files/user'))
            {
                mkdir(public_path() . '/files/user', 0755, true);
            }

            // Make sure the original filename is sanitized
            $file = pathinfo($request->file('document')->getClientOriginalName());
            $fileName = preg_replace('/[^a-z0-9-_]/', '', $file['filename']) . "." . preg_replace('/[^a-z0-9-_]/', '', $file['extension']);

            // Move file to uploads directory
            $fileName = time() . '-' . $fileName;
            $request->file('document')->move(public_path() . '/files/user', $fileName);
        }

        return
        [
            'name' => $file['filename'],
            'file' => $fileName
        ];
    }

    // Helper function to attach a document to an answer
    private function createDocument($answer, $upload)
    {
        $document = new Document;
        $document->name = $upload['name'];
        $document->file = $upload['file'];
        $document->application_id = $answer->application_id;
        $document->answer_id = $answer->id;
        $document->user_id = Auth::user()->id;
        $document->save();

        return $document;
    }

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
            $upload = $this->handleUpload($request);

            // Save new document
            $document = $this->createDocument($answer, $upload);
        }

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

        if($answer->application->status != 'new')
        {
            $request->session()->flash('error', 'Your application has been submitted, you may no longer make changes.');
            return redirect('/applications/' . $application->id . '/review');
        }

        $input = $request->all();
        $answer->update($input);

        // Check if a file needs to be uploaded
        if($answer->question->type == 'file')
        {
            // Save uploaded file
            $upload = $this->handleUpload($request);

            // Save new document
            $document = $this->createDocument($answer, $upload);
        }

        $request->session()->flash('success', 'Your answer has been saved.');
        return redirect('/applications/' . $answer->application->id);
    }
}

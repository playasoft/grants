<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;

use App\Models\Question;
use App\Models\Round;

use App\Misc\Helper;


class QuestionController extends Controller
{
    function listQuestions()
    {
        $rounds = Round::orderBy('start_date', 'desc')->get();
        return view('pages/questions/list', compact('rounds'));
    }

    function createQuestion(QuestionRequest $request)
    {
        // Double check to make sure the current user is authorized to do this...
        $this->authorize('create-question');

        $input = $request->all();
        $question = Question::create($input);

        $request->session()->flash('success', 'Your question has been created.');
        return redirect('/questions');
    }

    function createQuestionForm()
    {
        $rounds = Round::orderBy('start_date', 'desc')->get();
        $roundDropdown = Helper::makeDropdown($rounds, 'id', 'name');

        return view('pages/questions/create', compact('roundDropdown'));
    }

    function editQuestion(QuestionRequest $request, Question $question)
    {
        // Double check to make sure the current user is authorized to do this...
        $this->authorize('edit-question');

        $input = $request->all();
        $question->update($input);

        $request->session()->flash('success', 'The question has been updated.');
        return redirect('/questions');
    }

    function editQuestionForm(Question $question)
    {
        $rounds = Round::orderBy('start_date', 'desc')->get();
        $roundDropdown = Helper::makeDropdown($rounds, 'id', 'name');

        return view('pages/questions/edit', compact('question', 'roundDropdown'));
    }

    function deleteQuestion(Request $request, Question $question)
    {
        // Double check to make sure the current user is authorized to do this...
        $this->authorize('delete-question');
        $question->delete();

        $request->session()->flash('success', 'The question has been deleted.');
        return redirect('/questions');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Round;
use App\Http\Requests\RoundRequest;


class RoundController extends Controller
{
    function listRounds()
    {
        $rounds = Round::latest()->get();
        return view('pages/round/list', compact('rounds'));
    }

    function createRound(RoundRequest $request)
    {
        // Double check to make sure the current user is authorized to do this...
        $this->authorize('create-round');

        $input = $request->all();

        // TODO: Is there a better way to do this automatically?
        $input['budget'] =  filter_var($input['budget'], FILTER_SANITIZE_NUMBER_FLOAT);
        $input['min_request_amount'] = filter_var($input['min_request_amount'], FILTER_SANITIZE_NUMBER_FLOAT);
        $input['max_request_amount'] = filter_var($input['max_request_amount'], FILTER_SANITIZE_NUMBER_FLOAT);
        $round = Round::create($input);

        $request->session()->flash('success', 'Your round has been created.');
        return redirect('/rounds');
    }

    function createRoundForm()
    {
        return view('pages/round/create');
    }

    function editRound(RoundRequest $request, Round $round)
    {
        // Double check to make sure the current user is authorized to do this...
        $this->authorize('edit-round');

        $input = $request->all();
        $round->update($input);

        $request->session()->flash('success', 'The round has been updated.');
        return redirect('/rounds');
    }

    function editRoundForm(Round $round)
    {
        return view('pages/round/edit', compact('round'));
    }

    function deleteRound(Request $request, Round $round)
    {
        // Double check to make sure the current user is authorized to do this...
        $this->authorize('delete-round');
        $round->delete();

        $request->session()->flash('success', 'The round has been deleted.');
        return redirect('/rounds');
    }
}

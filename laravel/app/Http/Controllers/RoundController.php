<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Round;
use App\Http\Requests\RoundRequest;
use App\Misc\Helper;

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
        $input['budget'] = Helper::filterFloat($input['budget']);
        $input['min_request_amount'] = Helper::filterFloat($input['min_request_amount']);
        $input['max_request_amount'] = Helper::filterFloat($input['max_request_amount']);
        $round = Round::create($input);

        // Should we copy data from an old grant round?
        if(is_numeric($input['copy_data'])) {
            // Check if the requested round actually exists
            $oldRound = Round::find($input['copy_data']);

            if(!empty($oldRound)) {
                // Loop through old questions and copy into the new round
                foreach($oldRound->questions as $oldQuestion) {
                    $newQuestion = $oldQuestion->replicate()->fill([
                        'round_id' => $round->id
                    ]);

                    $newQuestion->save();
                }

                // Loop through old criteria and copy into the new round
                foreach($oldRound->criteria as $oldCriteria) {
                    $newCriteria = $oldCriteria->replicate()->fill([
                        'round_id' => $round->id
                    ]);

                    $newCriteria->save();
                }
            }
        }

        $request->session()->flash('success', 'Your round has been created.');
        return redirect('/rounds');
    }

    function createRoundForm()
    {
        $rounds = Round::latest()->get();
        return view('pages/round/create', compact('rounds'));
    }

    function editRound(RoundRequest $request, Round $round)
    {
        // Double check to make sure the current user is authorized to do this...
        $this->authorize('edit-round');

        $input = $request->all();

        // TODO: Is there a better way to do this automatically?
        $input['budget'] =  Helper::filterFloat($input['budget']);
        $input['min_request_amount'] = Helper::filterFloat($input['min_request_amount']);
        $input['max_request_amount'] = Helper::filterFloat($input['max_request_amount']);

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

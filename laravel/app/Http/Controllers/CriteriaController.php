<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CriteriaRequest;

use App\Models\Criteria;
use App\Models\Round;

use App\Misc\Helper;


class CriteriaController extends Controller
{
    function listCriteria()
    {
        $rounds = Round::orderBy('start_date', 'desc')->get();
        return view('pages/criteria/list', compact('rounds'));
    }

    function createCriteria(CriteriaRequest $request)
    {
        // Double check to make sure the current user is authorized to do this...
        $this->authorize('create-criteria');

        $input = $request->all();
        $criteria = Criteria::create($input);

        $request->session()->flash('success', 'Your criteria has been created.');
        return redirect('/criteria');
    }

    function createCriteriaForm()
    {
        $rounds = Round::orderBy('start_date', 'desc')->get();
        $roundDropdown = Helper::makeDropdown($rounds, 'id', 'name');

        return view('pages/criteria/create', compact('roundDropdown'));
    }

    function editCriteria(CriteriaRequest $request, Criteria $criteria)
    {
        // Double check to make sure the current user is authorized to do this...
        $this->authorize('edit-criteria');

        $input = $request->all();
        $criteria->update($input);

        $request->session()->flash('success', 'The criteria has been updated.');
        return redirect('/criteria');
    }

    function editCriteriaForm(Criteria $criteria)
    {
        $rounds = Round::orderBy('start_date', 'desc')->get();
        $roundDropdown = Helper::makeDropdown($rounds, 'id', 'name');

        return view('pages/criteria/edit', compact('criteria', 'roundDropdown'));
    }

    function deleteCriteria(Request $request, Criteria $criteria)
    {
        // Double check to make sure the current user is authorized to do this...
        $this->authorize('delete-criteria');
        $criteria->delete();

        $request->session()->flash('success', 'The criteria has been deleted.');
        return redirect('/criteria');
    }
}

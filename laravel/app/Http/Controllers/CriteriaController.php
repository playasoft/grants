<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Criteria;
use App\Http\Requests\CriteriaRequest;


class CriteriaController extends Controller
{
    function listCriteria()
    {
        $criteria = Criteria::latest()->get();
        return view('pages/criteria/list', compact('criteria'));
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
        return view('pages/criteria/create');
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
        return view('pages/criteria/edit', compact('criteria'));
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

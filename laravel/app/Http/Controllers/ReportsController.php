<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Application;
use App\Models\Round;

class ReportsController extends Controller
{
    //create a new report
    public function view()
    {   
        $rounds = Round::orderBy('updated_at', 'asc')->get();
    	return view('pages/reports/view', compact('rounds'));
    }

    public function generateReport(Request $request)
    {

    }
}

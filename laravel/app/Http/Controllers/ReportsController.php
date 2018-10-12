<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportsController extends Controller
{
    //create a new report
    public function create()
    {
    	return view('pages/reports/create');
    }

    public function view()
    {
    	return view('pages/reports/view');
    }

    public function generateReport(Request $request)
    {

    }
}

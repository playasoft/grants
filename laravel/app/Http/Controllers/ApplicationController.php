<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ApplicationController extends Controller
{
    public function listApplications()
    {
        // check user role
        // display all applicaitons if admin
        // otherwise only display your own

        return view('pages/applications/list');
    }

    public function createApplication()
    {
        return "// todo";
    }

    public function createApplicationForm()
    {
        return view('pages/applications/create');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Round;
use App\Models\Application;

use Carbon\Carbon;

class PageController extends Controller
{
    // Display different home page views if you're logged in or out
    public function home()
    {
        $upcoming = Round::where('end_date', '>', Carbon::now())->orderBy('start_date', 'desc')->get();
        $current = $upcoming->shift();

        if($this->auth->check())
        {
            if(in_array($this->auth->user()->role, ['judge', 'observer']))
            {
                $applications = Application::whereIn('status', ['submitted', 'review'])->get();
            }
            else
            {
                $applications = $this->auth->user()->applications;
            }
            
            return view('pages/dashboard', compact('applications', 'current', 'upcoming'));
        }
        else
        {
            return view('pages/home', compact('current', 'upcoming'));
        }
    }
    
    // General purpose function for displaying views
    public function view(Request $request)
    {
        return view('pages/' . $request->path());
    }
}

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
        $ongoing = Round::ongoing();
        $upcoming = Round::upcoming();

        if($this->auth->check())
        {
            if(in_array($this->auth->user()->role, ['judge', 'observer']))
            {
                // Get all applications where the application is submitted and the judge has not submitted a score(judged).
                $applications = Application::whereIn('applications.status', ['submitted', 'review'])
                    ->leftJoin('judged', 'judged.application_id', '=', 'applications.id')
                    ->whereNull('judged.user_id')
                    ->orderBy('applications.updated_at', 'asc')
                    ->get(['applications.*']);
            }
            else
            {
                $applications = $this->auth->user()->applications;
            }
            $rounds = Round::orderBy('start_date', 'desc')->get();
            return view('pages/dashboard', compact('applications', 'ongoing', 'upcoming', 'rounds'));
        }
        else
        {
            return view('pages/home', compact('ongoing', 'upcoming'));
        }
    }

    // General purpose function for displaying views
    public function view(Request $request)
    {
        return view('pages/' . $request->path());
    }
}

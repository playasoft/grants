<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use App\Models\Document;
use App\Models\Application;
use App\Models\User;

class DocumentController extends Controller
{
    public function deleteDocument(Request $request, Document $document)
    {
        // Does this document belong to the current user?
        if($document->user->id != Auth::user()->id)
        {
            $request->session()->flash('error', 'Only the person who uploaded a file may delete it.');
            return redirect('/login');
        }

        $application = $document->application->id;

        $document->delete();
        $request->session()->flash('success', 'Your file has been deleted.');
        return redirect()->back();
    }

    public function addDocument(Application $application, Request $request)
    {
        // ToDo add judge and admin use
        if($application->user->id != Auth::user()->id)
        {
            $request->session()->flash('error', 'Only the person who created an application may answer questions for it.');
            return redirect('/login');
        }

        // Save uploaded file
        $upload = Document::handleUpload($request);

        // Save new document
        Document::createDocument($application, $upload, null);

        $request->session()->flash('success', 'Your file has been added.');
        return redirect()->back();

    }
}

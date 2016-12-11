<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Document;
use App\Models\Application;
use App\Models\User;

class Document extends Model
{
    protected $fillable = ['name', 'description'];

    // Documents belong to an application
    public function application()
    {
        return $this->belongsTo('App\Models\Application');
    }

    // Documents can belong to the answer of a question
    public function answer()
    {
        return $this->belongsTo('App\Models\Answer');
    }

    // Documents belong to users
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    // Helper function to make sure uploaded files have unique filenames
    public static function handleUpload($request)
    {
        $fileName = false;
        $destinationPath = public_path() . '/files/user';

        if(!$request->hasFile('document'))
        {
            $request->session()->flash('error', 'No file uploaded. Make sure you select a file to upload.');
            return false;
        }

        // Create upload folder if it doesn't exist
        if(!file_exists($destinationPath))
        {
            mkdir($destinationPath, 0755, true);
        }

        // Make sure the original filename is sanitized
        $file = pathinfo($request->file('document')->getClientOriginalName());
        $fileName = preg_replace('/[^a-z0-9-_]/', '', $file['filename']) . "." . preg_replace('/[^a-z0-9-_]/', '', $file['extension']);

        // Move file to uploads directory
        $fileName = time() . '-' . $fileName;
        $request->file('document')->move($destinationPath, $fileName);

        return
        [
            'name' => $file['filename'],
            'file' => $fileName
        ];
    }

    // Helper function to attach a document to an application
    public static function createDocument($application, $upload, $answer = null)
    {
        $document = new Document;
        $document->name = $upload['name'];
        $document->file = $upload['file'];
        $document->application_id = $application->id;
        $document->user_id = Auth::user()->id;
        if($answer)
        {
            $document->answer_id = $answer->id;
        }
        $document->save();

        return $document;
    }

}

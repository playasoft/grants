<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['answer'];

    // Answers belong to an application
    public function application()
    {
        return $this->belongsTo('App\Models\Application');
    }

    // Answers belong to a question
    public function question()
    {
        return $this->belongsTo('App\Models\Question');
    }

    // Answers can have associated documents
    public function documents()
    {
        return $this->hasMany('App\Models\Document');
    }

    // Convenience for getting the user that created an answer
    public function getUserAttribute()
    {
        return $this->application->user;
    }
}

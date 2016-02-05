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
}

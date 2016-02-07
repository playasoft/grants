<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['name', 'description'];

    // Documents belong to an application
    public function application()
    {
        return $this->belongsTo('App\Models\Application');
    }

    // Documents can belong to a question
    public function question()
    {
        return $this->belongsTo('App\Models\Question');
    }

    // Documents belong to users
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}

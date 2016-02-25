<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $fillable = ['score', 'answer'];

    // Scores belong to an application
    public function application()
    {
        return $this->belongsTo('App\Models\Application');
    }

    // Scores belong to criteria
    public function criteria()
    {
        return $this->belongsTo('App\Models\Criteria');
    }

    // Scores are set by a specific user (judges)
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}

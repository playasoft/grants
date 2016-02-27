<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedback';

    // Feedback belong to an application
    public function application()
    {
        return $this->belongsTo('App\Models\Application');
    }

    // Feedback is requested by a specific user (judges)
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}

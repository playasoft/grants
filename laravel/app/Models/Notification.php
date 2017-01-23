<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public function from()
    {
        return $this->belongsTo('App\Models\User', 'user_from');
    }

    public function to()
    {
        return $this->belongsTo('App\Models\User', 'user_to');
    }
}

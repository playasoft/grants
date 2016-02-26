<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Judged extends Model
{
    protected $table = 'judged';

    // Applications can be judged
    public function application()
    {
        return $this->belongsTo('App\Models\Application');
    }

    // Users do the judging
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}

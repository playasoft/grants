<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{
    protected $table = 'signatures';
    protected $fillable = ['contractID', 'slug', 'status'];

    // Signature belongs to an application
    public function application()
    {
        return $this->belongsTo('App\Models\Application');
    }
    // Signature belongs to a user
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}

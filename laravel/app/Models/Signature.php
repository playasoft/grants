<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{

    protected $table = "signatures";
    protected $fillable = ['contractID', 'slug', 'status'];
    protected $dates = ['sent', 'opened', 'signed'];

    // Signature belongs to an application
    public function application()
    {
        return $this->belongsTo('App\Models\Application');
    }

}

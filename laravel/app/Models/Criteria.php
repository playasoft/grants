<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    // Table has to be manually defined because laravel thinks "criterias" is the plural...
    protected $table = 'criteria';

    protected $fillable = ['round_id', 'question', 'type', 'required'];

    // Criteria belongs to a round
    public function round()
    {
        return $this->belongsTo('App\Models\Round');
    }
}

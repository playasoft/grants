<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    protected $fillable = ['name', 'description', 'budget', 'min_request_amount', 'max_request_amount', 'start_date', 'end_date'];
}

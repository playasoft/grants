<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    // Table has to be manually defined because laravel thinks "criterias" is the plural...
    protected $table = 'criteria';
}

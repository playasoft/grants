<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Round extends Model
{
    protected $fillable = ['name', 'description', 'budget', 'min_request_amount', 'max_request_amount', 'start_date', 'end_date'];

    static public function upcoming()
    {
        return self::where('start_date', '>', Carbon::now())
                    ->orderBy('start_date', 'asc')->get();
    }

    static public function ongoing()
    {
        // Subtract one day to the end_date check, because the end_date column is a date and not datetime
        // For example, if the current time is the same day as the end date, the current time will always be greater
        return self::where('start_date', '<', Carbon::now())
                    ->where('end_date', '>', Carbon::now()->subDay(1))
                    ->orderBy('start_date', 'asc')->get();
    }

    static public function ended()
    {
        return self::where('end_date', '<', Carbon::now()->subDay(1))
                    ->orderBy('start_date', 'desc')->get();
    }

}

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

    // Helper function to determine if a round is currently ongoing, upcoming, or ended
    public function status()
    {
        $start = Carbon::createFromFormat("Y-m-d", $this->start_date);
        $end = Carbon::createFromFormat("Y-m-d", $this->end_date);
        $now = Carbon::now();

        // Set the end date to 23:59:59
        $end->addHours(23)->addMinutes(59)->addSeconds(59);

        if($now->lt($start))
        {
            // If the current date is less than the start date, this round is upcoming
            return 'upcoming';
        }
        elseif($now->between($start, $end))
        {
            // If the current date is between the start and end date, this round is ongoing
            return 'ongoing';
        }
        else
        {
            // Otherwise it must be over!
            return 'ended';
        }
    }
}

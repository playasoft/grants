<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use App\Models\Round;

class RoundsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($start_date = null)
    {
        $event = factory(Round::class)->create(['start_date' => $start_date ?: Carbon::now()]); 
    }
}

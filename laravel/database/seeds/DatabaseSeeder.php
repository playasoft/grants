<?php

use Illuminate\Database\Seeder;

use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     *
     * Usage: php artisan db:seed
     *
     * Populates the DB with 5 Judges
     * and runs the rest of the seeds.
     *
     * @return void
     */
    public function run()
    {
        $judges = factory(User::class, 5)
            ->create(['role' => 'judge']);

        $this->call(RoundsSeeder::class);

        $this->call(JudgmentDay::class);

        $this->call(ApplicantResponds::class);
    }
}

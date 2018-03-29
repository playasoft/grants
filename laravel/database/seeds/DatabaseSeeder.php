<?php

use Illuminate\Database\Seeder;

use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserTableSeeder::class);
        $judges = factory(User::class, 5)
            ->create(['role' => 'judge']);

        $this->call(RoundsSeeder::class);
    }
}

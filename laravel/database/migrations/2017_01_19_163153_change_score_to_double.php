<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeScoreToDouble extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        //ALTER TABLE tablename MODIFY COLUMN columnname DOUBLE;
        DB::statement('ALTER TABLE applications MODIFY COLUMN objective_score DOUBLE;');
        DB::statement('ALTER TABLE applications MODIFY COLUMN subjective_score DOUBLE;');
        DB::statement('ALTER TABLE applications MODIFY COLUMN total_score DOUBLE;');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE applications MODIFY COLUMN objective_score INTEGER;');
        DB::statement('ALTER TABLE applications MODIFY COLUMN subjective_score INTEGER;');
        DB::statement('ALTER TABLE applications MODIFY COLUMN total_score INTEGER;');
    }
}

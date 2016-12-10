<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rounds', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('name', 64);
            $table->string('description');
            $table->decimal('budget', 8, 2);
            $table->decimal('min_request_amount', 8, 2);
            $table->decimal('max_request_amount', 8, 2);
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Schema::table('applications', function (Blueprint $table)
        {
            $table->integer('round_id')->unsigned();
            $table->foreign('round_id')->references('id')->on('rounds');
        });

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Schema::table('applications', function (Blueprint $table)
        {
            $table->dropForeign('round_id');
            $table->dropColumn('round_id');
        });

        Schema::drop('rounds');

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

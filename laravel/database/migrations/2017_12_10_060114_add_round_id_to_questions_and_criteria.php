<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRoundIdToQuestionsAndCriteria extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questions', function (Blueprint $table)
        {
            $table->integer('round_id')->unsigned()->after('id');
        });

        Schema::table('questions', function (Blueprint $table)
        {
            // We have to set all existing rows to use the first round by default to avoid foreign constraint errors
            DB::table('questions')->update(['round_id' => 1]);
            $table->foreign('round_id')->references('id')->on('rounds')->onDelete('cascade');
        });

        Schema::table('criteria', function (Blueprint $table)
        {
            $table->integer('round_id')->unsigned()->after('id');
        });

        Schema::table('criteria', function (Blueprint $table)
        {
            DB::table('criteria')->update(['round_id' => 1]);
            $table->foreign('round_id')->references('id')->on('rounds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questions', function (Blueprint $table)
        {
            $table->dropForeign('questions_round_id_foreign');
            $table->dropColumn('round_id');
        });

        Schema::table('criteria', function (Blueprint $table)
        {
            $table->dropForeign('criteria_round_id_foreign');
            $table->dropColumn('round_id');
        });
    }
}

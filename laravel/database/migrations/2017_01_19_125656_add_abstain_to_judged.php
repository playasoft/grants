<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAbstainToJudged extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('judged', function (Blueprint $table) {
            //
            $table->enum('status', ['judged', 'abstain']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('judged', function (Blueprint $table) {
            //
            $table->dropColumn('status');
        });
    }
}

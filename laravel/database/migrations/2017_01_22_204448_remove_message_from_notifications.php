<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveMessageFromNotifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
      */
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table)
        {
            $table->dropColumn('message');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table)
        {
            $table->text('message');
        });
    }
}

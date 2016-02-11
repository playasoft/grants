<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFileOption extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("Alter table `questions` modify column `type` enum('input', 'text', 'dropdown', 'boolean', 'file')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("Alter table `questions` modify column `type` enum('input', 'text', 'dropdown', 'boolean')");
    }
}

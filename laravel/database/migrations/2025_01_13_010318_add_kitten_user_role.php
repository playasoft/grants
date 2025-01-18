<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKittenUserRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // NOTE: Modern versions of Laravel allow you to natively edit enumn columns, but in this version we have to use a raw SQL query
        // This is incompatible with SQLite and only works for MySQL / MariaDB databases
        DB::statement("ALTER TABLE `users` MODIFY COLUMN `role` ENUM('admin', 'applicant', 'judge', 'kitten', 'observer')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE `users` MODIFY COLUMN `role` ENUM('admin', 'applicant', 'judge', 'observer')");
    }
}

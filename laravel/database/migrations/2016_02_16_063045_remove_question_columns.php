<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveQuestionColumns extends Migration
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
            $table->dropColumn('status');
            $table->dropColumn('role');
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
            $table->enum('status', ['new', 'submitted', 'review', 'follow-up', 'accepted', 'rejected']);
            $table->enum('role', ['applicant', 'judge']);
        });
    }
}

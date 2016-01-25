<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('question');
            $table->enum('type', ['input', 'text', 'dropdown', 'boolean']);
            $table->enum('status', ['new', 'submitted', 'review', 'follow-up', 'accepted', 'rejected']);
            $table->enum('role', ['applicant', 'judge']);
            $table->text('options');
            $table->boolean('required');
            $table->integer('parent')->nullable();
            $table->integer('order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('questions');
    }
}

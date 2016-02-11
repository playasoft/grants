<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->string('file');
            $table->integer('application_id')->unsigned();
            $table->foreign('application_id')->references('id')->on('applications')->onDelete('cascade');
            $table->integer('answer_id')->unsigned()->nullable();
            $table->foreign('answer_id')->references('id')->on('answers')->onDelete('set null');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::drop('documents');
    }
}

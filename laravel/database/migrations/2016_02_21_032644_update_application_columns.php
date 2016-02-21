<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateApplicationColumns extends Migration
{
    // A bit of a hack to let DBAL rename columns in a table with enums
    // Fixes "Unknown database type enum requested, Doctrine\DBAL\Platforms\MySqlPlatform may not support it." error
    public function __construct()
    {
        DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
    }
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Rename columns
        Schema::table('applications', function (Blueprint $table)
        {
            $table->renameColumn('applicant_score', 'objective_score');
            $table->renameColumn('judge_score', 'subjective_score');
        });

        // Add new columns
        Schema::table('applications', function (Blueprint $table)
        {
            $table->integer('total_score')->after('subjective_score');
            $table->boolean('scored')->after('total_score');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applications', function (Blueprint $table)
        {
            $table->renameColumn('objective_score', 'applicant_score');
            $table->renameColumn('subjective_score', 'judge_score');
            $table->dropColumn(['total_score', 'scored']);
        });
    }
}

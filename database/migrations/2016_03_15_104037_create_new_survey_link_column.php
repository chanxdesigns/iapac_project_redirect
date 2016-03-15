<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewSurveyLinkColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects_list', function (Blueprint $table) {
            $table->string('Survey Link')->after("Q_Link");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects_list', function (Blueprint $table) {
            $table->dropColumn('Survey Link');
        });
    }
}

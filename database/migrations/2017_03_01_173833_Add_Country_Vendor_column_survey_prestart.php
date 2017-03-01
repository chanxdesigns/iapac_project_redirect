<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCountryVendorColumnSurveyPrestart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('survey_prestart', function ($table) {
            $table->string('vendor');
            $table->string('project_id');
            $table->string('country');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('survey_prestart', function ($table) {
            $table->dropColumn(['vendor','country','project_id']);
        });
    }
}

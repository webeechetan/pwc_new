<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToHomepageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('homepage', function (Blueprint $table) {
            $table -> string('event_title');
            $table -> string('event_subtitle');
            $table -> string('case_study_title');
            $table -> string('case_study_subtitle');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('homepage', function (Blueprint $table) {
            $table->dropColumn('event_title');
            $table->dropColumn('event_subtitle');
            $table->dropColumn('case_study_title');
            $table->dropColumn('case_study_subtitle');
        });
    }
}

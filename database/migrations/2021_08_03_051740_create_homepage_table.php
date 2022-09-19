<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomepageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homepage', function (Blueprint $table) {
            $table->id();
            $table->string('banner_title');
            $table->string('banner_caption1');
            $table->string('banner_caption2');
            $table->string('banner_subtitle');
            $table->string('banner_button');
            $table->string('banner_button_action');

            $table->string('s1_count1');
            $table->string('s1_heading1');
            $table->string('s1_count2');
            $table->string('s1_heading2');
            $table->string('s1_count3');
            $table->string('s1_heading3');
            $table->string('s1_count4');
            $table->string('s1_heading4');

            $table->string('s2_heading');
            $table->string('s2_title');
            $table->longtext('s2_description');

            $table->string('s3_heading');
            $table->string('s3_title');
            $table->mediumtext('s3_description');
            $table->string('s3_email');
            $table->string('s3_contact_heading');
            $table->string('s3_contact_subheading');
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
        Schema::dropIfExists('homepage');
    }
}

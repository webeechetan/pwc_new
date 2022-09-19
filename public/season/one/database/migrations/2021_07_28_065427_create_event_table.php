<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active') -> default(1);
            $table->string('added_by') -> default(1);
            $table->string('title');
            $table->string('category');
            $table->string('type');
            $table->string('price');
            $table->string('event_for');
            $table->longtext('pilot_companies_id');
            $table->longtext('startup_id');
            $table->date('event_from');
            $table->date('event_to');
            $table->string('duration');
            $table->time('event_start');
            $table->time('event_end');
            $table->mediumText('short_description');
            $table->longtext('description');
            $table->longtext('collateral');
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
        Schema::dropIfExists('event');
    }
}

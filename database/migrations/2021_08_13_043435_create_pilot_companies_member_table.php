<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePilotCompaniesMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pilot_companies_member', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(1);
            $table->unsignedBigInteger('pilot_companies_id');
            $table->foreign('pilot_companies_id')->references('id')->on('pilot_companies');
            $table->string('name');
            $table->string('designation');
            $table->string('email');
            $table->string('password');
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
        Schema::dropIfExists('pilot_companies');
    }
}

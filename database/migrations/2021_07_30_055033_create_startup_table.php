<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStartupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('startup', function (Blueprint $table) {
            $table->id();
            $table->string('startup_id')->nullable();
            $table->boolean('is_active') -> default(1);
            $table->string('added_by') -> default(1);
            $table->string('updated_by') -> default(1);
            $table->boolean('request') -> default(0);
            $table->longtext('collateral');
            $table->string('company_name');
            $table->longtext('description');
            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->string('pincode');
            $table->string('zone');
            $table->string('address');
            $table->string('founded_on')->nullable();
            $table->string('company_type');
            $table->string('industry')->nullable();
            $table->longtext('type_of_services');
            $table->string('specialities')->nullable();
            $table->string('company_size');
            $table->string('revenue')->nullable();
            // $table->string('certified');
            // $table->string('title');
            $table->string('website')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('instagram')->nullable();
            // $table->string('name');
            // $table->string('designation');
            $table->string('email');
            $table->string('phone');
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
        Schema::dropIfExists('startup');
    }
}

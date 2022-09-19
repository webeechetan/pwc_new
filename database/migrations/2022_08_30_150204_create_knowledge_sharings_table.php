<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKnowledgeSharingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('knowledge_sharings', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active') -> default(1);
            $table->string('added_by') -> default(1);
            $table->string('updated_by') -> default(1);
            $table->string('title');
            $table->longtext('overview');
            $table->longtext('description');
            $table->string('overview_image')->default('default_overview_image.png');
            $table->string('banner_image')->default('default_banner_image.png');
            $table->string('files')->default('default_banner_image.png');
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
        Schema::dropIfExists('knowledge_sharings');
    }
}

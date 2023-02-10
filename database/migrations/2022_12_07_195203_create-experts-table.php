<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('experts',function (Blueprint $table){
            $table->id();
            $table->string('name')->unique();
            $table->text('experience');
            $table->text('info');
            $table->string('image_path');
            $table->integer('available_time');
            $table->string('specialties');
            $table->boolean('is_expert')->default(false);
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
        Schema::dropIfExists('experts');
    }
};

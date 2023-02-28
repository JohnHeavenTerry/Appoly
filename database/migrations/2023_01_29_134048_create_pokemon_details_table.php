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
        Schema::create('pokemonDetails', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('hp');
            $table->integer('attack');
            $table->integer('defense');
            $table->integer('special-attack');
            $table->integer('special-defense');
            $table->integer('speed');
            $table->string('height');
            $table->string('weight');
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
        Schema::dropIfExists('fruits');
    }
};

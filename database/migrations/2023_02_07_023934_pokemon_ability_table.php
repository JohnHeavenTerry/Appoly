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
        Schema::create('pokemon_ability', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ability_id');
            $table->bigInteger('pokemon_id');
            $table->foreign('ability_id')->references('id')->on('ability')->onDelete('cascade');
            $table->foreign('pokemon_id')->references('id')->on('pokemonDetails')->onDelete('cascade');
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
        /* drop foreign key first */
        Schema::table('pokemon_ability', function (Blueprint $table) {
            $table->dropForeign(['ability_id']);
            $table->dropColumn('ability_id');
            $table->dropForeign(['pokemon_id']);
            $table->dropColumn('pokemon_id');
        });

        Schema::dropIfExists('pokemon_ability');

    }
};

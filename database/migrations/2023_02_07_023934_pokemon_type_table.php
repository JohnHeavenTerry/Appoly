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
        Schema::create('pokemon_type', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('type_id');
            $table->bigInteger('pokemon_id');
            $table->foreign('type_id')->references('id')->on('type')->onDelete('cascade');
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
        Schema::table('fruit_product', function (Blueprint $table) {
            $table->dropForeign(['item_type_id']);
            $table->dropColumn('item_type_id');
        });

        Schema::dropIfExists('fruit_product');

    }
};

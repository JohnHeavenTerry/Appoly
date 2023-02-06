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
        Schema::create('fruit_children', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('item')->nullable();
            $table->string('item_type')->nullable();
            $table->bigInteger('fruit_id');
            $table->foreign('fruit_id')->references('id')->on('fruits')->onDelete('cascade');
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
        Schema::table('fruit_children', function (Blueprint $table) {
            $table->dropForeign(['fruit_id']);
            $table->dropColumn('fruit_id');
        });

        Schema::dropIfExists('fruit_children');
    }
};

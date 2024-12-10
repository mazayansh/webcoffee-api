<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('roasts', function (Blueprint $table) {
        $table->id(); // Ini berarti kolom id adalah unsignedBigInteger
        $table->string('name');
        $table->string('slug')->unique();
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
        Schema::dropIfExists('roast_levels');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Se crea la tabla para almacenar el historial de búsqueda.
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('param_city');
            $table->String('symbol');
            $table->String('coin');
            $table->String('climate');
            $table->String('exchangeRate');
            $table->float('budget',20,2);
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
        Schema::dropIfExists('histories');
    }
}

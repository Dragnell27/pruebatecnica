<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateParamTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //tabla para los tipos de parametros
        Schema::create('param_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        //Creo los datos necesarios una vez la tabla exista.
        DB::table('param_types')->insert([
            ['id'=> 1,'name' => 'countries'],
            ['id'=> 2,'name' => 'cities'],
            ['id'=> 3,'name' => 'coin'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('param_types');
    }
}

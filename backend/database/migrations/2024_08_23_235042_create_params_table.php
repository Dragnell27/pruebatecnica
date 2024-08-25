<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateParamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('params', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('param_id')->nullable();
            $table->unsignedBigInteger('param_type_id');
            $table->timestamps();
            $table->foreign('param_id')->references('id')->on('params')->onDelete('cascade');
            $table->foreign('param_type_id')->references('id')->on('param_types')->onDelete('cascade');
        });

        DB::table('params')->insert([
            //Países
            ['id'=> 1,'name' => 'England','param_id' => null,'param_type_id' => 1],
            ['id'=> 2,'name' => 'Japan','param_id' => null,'param_type_id' => 1],
            ['id'=> 3,'name' => 'India','param_id' => null,'param_type_id' => 1],
            ['id'=> 4,'name' => 'Denmark','param_id' => null,'param_type_id' => 1],

            //Ciudades de England
            ['id'=> 5,'name' => 'London','param_id' => 1,'param_type_id' => 2],
            ['id'=> 6,'name' => 'Manchester','param_id' => 1,'param_type_id' => 2],

            //ciudades de Japan
            ['id'=> 7,'name' => 'Tokyo','param_id' => 2,'param_type_id' => 2],
            ['id'=> 8,'name' => 'Osaka','param_id' => 2,'param_type_id' => 2],

            //ciudades India
            ['id'=> 9,'name' => 'Delhi','param_id' => 3,'param_type_id' => 2],
            ['id'=> 10,'name' => 'Mumbai','param_id' => 3,'param_type_id' => 2],

            //ciudades Denmark
            ['id'=> 11,'name' => 'Copenhagen','param_id' => 4,'param_type_id' => 2],
            ['id'=> 12,'name' => 'Aarhus','param_id' => 4,'param_type_id' => 2],

            //monedas
            ['id'=> 13,'name' => 'GBP,£,Libra_Esterlina,','param_id' => 1,'param_type_id' => 3],
            ['id'=> 14,'name' => 'JPY,¥,Yen_Japones','param_id' => 2,'param_type_id' => 3],
            ['id'=> 15,'name' => 'INR,₹,Rupia_India','param_id' => 3,'param_type_id' => 3],
            ['id'=> 16,'name' => 'DKK,kr,Corona_Danesa','param_id' => 4,'param_type_id' => 3],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('params');
    }
}

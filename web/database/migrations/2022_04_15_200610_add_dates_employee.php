<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDatesEmployee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {

            $table->string('sexo')->nullable(); // sexo
            $table->integer('bone')->nullable(); //bono de la persona
            $table->string('blood_type')->nullable(); // tipo de sangre
            $table->string('phone')->nullable(); // telefono
            $table->string('photo')->nullable(); // foto
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
          
            $table->dropColumn('sexo'); // sexo
            $table->dropColumn('bone'); //bono de la persona
            $table->dropColumn('blood_type'); // tipo de sangre
            $table->dropColumn('phone'); // telefono
            $table->dropColumn('photo'); // foto
        });
    }
}

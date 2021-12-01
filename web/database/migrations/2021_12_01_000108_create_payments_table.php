<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->nullable(); // fecha pago
            $table->integer('cpaysheet')->unsigned(); //codigo nomina
            $table->string('status'); //estado
            $table->integer('cconcept')->unsigned(); //codigo concepto
            $table->integer('days')->unsigned(); //dias (en caso de ser pago de aguinaldos)
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
        Schema::dropIfExists('payments');
    }
}

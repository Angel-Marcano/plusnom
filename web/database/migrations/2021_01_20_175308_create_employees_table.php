<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('document'); //cedula
            $table->string('full_name'); //nombre completo
            $table->string('chargue')->nullable(); // cargo
            $table->string('division')->nullable(); // divicion
            $table->date('admission_date')->nullable(); // fecha de ingreso
            $table->boolean('active')->default(true); // estado del trabajador
            $table->integer('cpaysheet')->unsigned(); //codigo nomina
            $table->integer('cpayments')->unsigned(); //codigo de pago
            $table->integer('rank')->unsigned(); //codigo de rango
            $table->integer('class')->unsigned(); //codigo de clase
            $table->integer('grade')->unsigned(); //codigo de grado
            $table->integer('level')->unsigned(); //codigo de nivel
            $table->integer('type_employee')->unsigned(); //codigo de pago
            $table->date('discharge_date')->nullable(); // fecha de egreso
            $table->integer('number_children')->nullable(); // numero de hijos


            /*
                rank, grade, type of employee, discharge date, number of children,
            */

            //$table->string('document');Payments

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}

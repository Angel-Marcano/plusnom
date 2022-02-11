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
            $table->string('division')->nullable(); // division
            $table->date('admission_date')->nullable(); // fecha de ingreso
            $table->date('level_profession')->nullable(); // nivel profesional
            $table->boolean('active')->default(true); // estado del trabajador
            $table->integer('cpaysheet')->unsigned(); //codigo nomina
            $table->integer('cpayments')->unsigned(); //codigo de pago
            $table->integer('rank')->nullable(); //codigo de rango - obreros
            $table->string('class')->nullable(); //codigo de clase - obreros
            $table->string('grade')->nullable(); //codigo de grado - empleados
            $table->integer('level')->nullable(); //codigo de nivel - empleados
            $table->integer('type_employee')->unsigned(); //codigo de pago
            $table->date('discharge_date')->nullable(); // fecha de egreso
            $table->integer('number_children')->nullable(); // numero de hijos
            $table->string('bank_account')->nullable(); // cuenta bancaria
            $table->string('account_type')->nullable(); // tipo de cuenta
            


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

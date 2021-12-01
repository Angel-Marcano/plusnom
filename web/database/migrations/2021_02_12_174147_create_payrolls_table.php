<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->string('document')->index();                    // cedula de empleado
            $table->decimal('Savings bank', 12, 2)->nullable();     // caja de ahorros
            $table->decimal('retirement_fund', 12, 2)->nullable();  //fondo de jubilacion
            $table->decimal('ivss', 12, 2)->nullable();             // seguro social
            $table->decimal('ipf', 12, 2)->nullable();              // Forced unemployement insurance (pf)
            $table->decimal('sfh', 12, 2)->nullable();              // Fondo de ahorro para la vivienda
            $table->decimal('antiquity_premium', 12, 2);            // Prima antiguedad
            $table->decimal('children_premium', 12, 2);             // Prima hijos
            $table->decimal('profession_premium', 12, 2);           // prima de profesion
            $table->decimal('base_salary', 12, 2);                  // Salario base
            $table->decimal('additional amount', 12, 2);            // Monto adicional
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
        Schema::dropIfExists('payrolls');
    }
}

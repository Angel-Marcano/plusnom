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
            $table->string('document')->index();
            $table->decimal('savings', 12, 2);
            $table->decimal('retirement_fund', 12, 2);
            $table->decimal('ilph', 12, 2);
            $table->decimal('ipf', 12, 2);
            $table->decimal('mdi', 12, 2);
            $table->decimal('seniority_premium', 12, 2);
            $table->decimal('children_premium', 12, 2);
            $table->decimal('profession_premium', 12, 2);
            $table->decimal('base_salary', 12, 2);
            $table->decimal('total_deductions', 12, 2);
            $table->decimal('total_allowances', 12, 2);
            $table->date('payment_date');
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

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Payroll;
use Carbon\Carbon;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $baseSalary = 800000.00;
        $employees = Employee::factory(100)->create();

        foreach($employees as $employee) {
            Payroll::create([
                 'document' => $employee->document,
                 'mdi' => 0.04,
                 'savings' => 0.00,
                 'ipf' => $baseSalary * 0.005,
                 'ilph' => $baseSalary * 0.01,
                 'retirement_fund' => $baseSalary * 0.03,
                 'base_salary' => $baseSalary,
                 'profession_premium' => 100000.00,
                 'children_premium' => 100000.00,
                 'seniority_premium' => 100000.00,
                 'payment_date' => Carbon::now(),
                 'total_deductions' => $baseSalary * 0.085,
                 'total_allowances' => 300000.00
            ]);
        }
    }
}

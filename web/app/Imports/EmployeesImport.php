<?php

namespace App\Imports;

use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class EmployeesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        return new Employee([
            'document' => $row['cedula'],
            'full_name' => $row['nombres_y_apellidos'],
            'admission_date' => Date::excelToDateTimeObject($row['fecha_ingreso'])->format('Y-m-d'),
            'chargue' => $row['cargo'],
            'division' => $row['dependencia'],
            'level_profession' => $row['nivel_profesional'],
            'cpaysheet' => $row['nomina'], //nomina codigo id
            'cpayments' => $row['cpayments'],
            'rank' => $row['rango'], //obrero
            'class' => $row['clase'], // obrero
            'grade' => $row['grado'], // Empleados
            'level' => $row['nivel'], //empleados
            'type_employee' => $row['tipo_empleado'], // igual a cpayshet pero este es el tipo fijo no de momento ejemplo un empleado puede ser fijo pero de momento esta en directivo.
            'number_children' => $row['numero_de_hijos'],
            'bank_account' => $row['cuenta'],
            'account_type' => $row['tipo_cuenta'] //0 ahorro -  1 Corriente
        ]);

    }
}

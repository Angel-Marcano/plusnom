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
            'admission_date' => Date::excelToDateTimeObject($row['fecha_ingreso'])->format('d-m-Y'),
            'chargue' => 'obrero contratado',
            'division' => $row['dependencia']
        ]);
    }
}

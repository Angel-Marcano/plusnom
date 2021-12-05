<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use App\Models\paysheet;

class PaysheetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Paysheet=['Alto nivel','Directivos','Empleados contratados','Empleados fijos','Empleados jubilados','Obreros contratados','Obreros fijos','Obreros jubilados'];

        foreach ($Paysheet as  $name) {
            paysheet::create([
                'name'=>$name
             ]);
        }
        
        
    }
}

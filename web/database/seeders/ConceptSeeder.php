<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use App\Models\concept;

class ConceptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $conceptos=['Quincena','Utilidades','Vacaciones'];

        foreach ($conceptos as  $Concepto) {
            concept::create([
                'name'=>$Concepto
             ]);
        }
        
        
    }
}

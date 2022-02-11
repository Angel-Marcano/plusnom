<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class paysheet extends Model
{
    use HasFactory;


    public function Employye()
    {
        return $this->hasMany(Employee::class, 'cpaysheet', 'id');
    }

    
}

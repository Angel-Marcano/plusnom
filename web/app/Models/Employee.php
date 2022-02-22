<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Payroll;
use App\Models\paysheet;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'employees';

    protected $fillable = [
        'document',
        'full_name',
        'chargue',
        'division',
        'admission_date',
        'level_profession',
        'cpaysheet',
        'cpayments',
        'rank',  //numerico obreros
        'class',  // 'MAXIMO'  Y 'MINIMO'
        'grade',
        'level',
        'type_employee',
        'number_children',
        'bank_account',
        'account_type',
    ];

    public function payrolls()
    {
        return $this->hasMany(Payroll::class, 'document', 'document');
    }

    public function paysheet()
    {
        return $this->belongsTo(paysheet::class, 'cpaysheet', 'id');
    }

    public function profile()
    {
        return $this->belongsToMany(Profile::class);
    }
}

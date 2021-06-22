<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $table = 'payrolls';

    protected $fillable = [
        'document',
        'savings_insurance',
        'retirement_fund',
        'ivss',
        'ipf', // Forced unemployement insurance
        'sfh', // Fondo de ahorro para la vivienda
        'antiquity_premium',
        'children_premium',
        'profession_premium',
        'base_salary',
        'payment_date'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'document', 'document');
    }
}

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
        'savings',
        'retirement_fund',
        'ilph',
        'ipf',
        'mdi',
        'seniority_premium',
        'children_premium',
        'profession_premium',
        'base_salary',
        'total_deductions',
        'total_allowances'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'document', 'document');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Payroll;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'employees';

    protected $fillable = [
        'document',
        'full_name',
        'admission_date',
        'chargue',
        'division'
    ];

    protected $appends = [ 'fullName' ];

    public function getFullNameAttribute()
    {
        return "{$this->name} {$this->surname}";
    }

    public function payrolls()
    {
        return $this->hasMany(Payroll::class, 'document', 'document');
    }

    public function profile()
    {
        return $this->belongsToMany(Profile::class);
    }
}

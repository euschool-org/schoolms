<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyFee extends Model
{
    use HasFactory;

    protected $casts = [
        'month' => 'date',
    ];

    protected $fillable = [
        'student_id',
        'month',
        'school_year',
        'fee',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}

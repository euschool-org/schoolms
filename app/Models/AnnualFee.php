<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnualFee extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'display_year',
        'year',
        'fee',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}

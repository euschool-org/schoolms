<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'payment_id',
        'payment_date',
        'payment_amount',
        'payer_name',
        'currency_rate',
        'nominal_amount',
        'percentage',
        'payment_type',
        'description',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function getPaymentTypeLabelAttribute()
    {
        return match ($this->payment_type) {
            0 => 'გადახდა',
            1 => '5% ფასდაკლება',
            2 => '10% ფასდაკლება',
            3 => 'ინდივიდუალური ფასდაკლება',
        };
    }

}

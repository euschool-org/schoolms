<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
        'private_number',
        'grade',
        'group',
        'sector',
        'parent_mail',
        'parent_number',
        'pupil_status',
        'additional_information',
        'contract_end_date',
        'monthly_payment',
        'currency',
        'parent_account',
        'income_account',
        'payment_quantity',
        'custom_discount',
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function getPupilStatusLabelAttribute()
    {
        switch ($this->pupil_status) {
            case -1:
                return 'Past';
            case 0:
                return 'Future';
            case 1:
                return 'Active';
            default:
                return 'Unknown';
        }
    }
}

<?php

namespace App\Models;

use Carbon\Carbon;
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
        'parent_firstname',
        'parent_lastname',
        'parent_mail',
        'parent_number',
        'pupil_status',
        'additional_information',
        'contract_start_date',
        'contract_end_date',
        'yearly_payment',
        'monthly_payment',
        'currency',
        'parent_account',
        'income_account',
        'payment_quantity',
        'custom_discount',
        'email_notifications',
        'mobile_notifications'
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

    public function getGradeLabelAttribute()
    {
        if (!$this->grade || !$this->contract_start_date) {
            return null;
        }

        $start = Carbon::parse($this->contract_start_date);
        $now = Carbon::now();

        // Adjust the year if the month is after August (i.e., the school year system)
        $adjustedNowYear = $now->month >= 8 ? $now->year + 1 : $now->year;
        $adjustedStartYear = $start->month >= 8 ? $start->year + 1 : $start->year;

        // Calculate the grade label
        return ($adjustedNowYear - $adjustedStartYear) + $this->grade;
    }

}

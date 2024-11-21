<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'private_number',
        'grade',
        'group',
        'sector',
        'parent_name',
        'parent_mail',
        'parent_number',
        'additional_information',
        'contract_start_date',
        'contract_end_date',
        'yearly_payment',
        'monthly_payment',
        'currency_id',
        'parent_account',
        'income_account',
        'payment_quantity',
        'custom_discount',
        'email_notifications',
        'mobile_notifications',
        'last_year_balance',
        'balance_change_year'
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function monthly_fees()
    {
        return $this->hasMany(MonthlyFee::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function getCurrencyLabelAttribute()
    {
        return $this->currency->code;
    }
    public function getPupilStatusLabelAttribute()
    {
        $now = Carbon::now();

        if (is_null($this->contract_start_date) && is_null($this->contract_end_date)) {
            return 'Unknown';
        }

        if ($this->contract_start_date <= $now &&
            (is_null($this->contract_end_date) || $this->contract_end_date >= $now)) {
            return 'Active';
        }

        if ($this->contract_start_date > $now) {
            return 'Future';
        }

        if ($this->contract_end_date < $now) {
            return 'Past';
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

        $calculatedGrade = ($adjustedNowYear - $adjustedStartYear) + $this->grade;
        if ($start > $now) {
            $calculatedGrade = $this->grade;
        }

        if ($calculatedGrade > 12) {
            $calculatedGrade = null;
        }
        return $calculatedGrade;
    }

}

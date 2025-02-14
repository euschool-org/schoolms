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
        'current_grade',
        'group',
        'sector',
        'parent_name',
        'parent_mail',
        'parent_number',
        'additional_information',
        'contract_start_date',
        'contract_end_date',
        'currency_id',
        'parent_account',
        'income_account',
        'payment_quantity',
        'custom_discount',
        'new_student_discount',
        'email_notifications',
        'last_year_balance',
        'balance_change_year',
        'payment_code'
    ];
    protected static function booted()
    {
        // Automatically set the 'payment_code' when a new student is being created
        static::creating(function ($student) {
            // Check if the payment_code is not already set
            if (empty($student->payment_code)) {
                // Generate a random 8-digit number and concatenate with 'ES'
                $student->payment_code = 'ES' . str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT);

                // Ensure the generated value is unique by checking the database
                while (self::where('payment_code', $student->payment_code)->exists()) {
                    // Generate another 8-digit number if the current one already exists
                    $student->payment_code = 'ES' . str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT);
                }
            }
        });
    }

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

    public function yearlyFee($invoice = false)
    {
        if ($invoice) {
            $schoolYear = now()->year . '-' . (now()->year + 1);
        } else {
            $schoolYear = now()->month > 6
                ? now()->year . '-' . (now()->year + 1)
                : (now()->year - 1) . '-' . now()->year;
        }


        // Dynamically load the sum of the fees for the specified school year
        $this->loadSum([
            'monthly_fees as year_fee' => function ($query) use ($schoolYear) {
                $query->where('school_year', $schoolYear);
            }
        ], 'fee');

        return $this->year_fee;
    }

    public function year_payment()
    {
        $schoolYear = now()->month > 6
            ? now()->startOfYear()->setMonth(7)->startOfMonth()
            : now()->subYear()->startOfYear()->setMonth(7)->startOfMonth();

        $this->loadSum([
            'payments as year_payment' => function ($query) use ($schoolYear) {
                $query->where('payment_date','>', $schoolYear);
            }
            ], 'nominal_amount');

        return $this->year_payment;
    }
    public function getGradeLabelAttribute()
    {
        if (!$this->grade || !$this->contract_start_date) {
            return null;
        }

        $start = Carbon::parse($this->contract_start_date);
        $now = Carbon::now();

        // Adjust the year if the month is after August (i.e., the school year system)
        $adjustedNowYear = $now->month >= 7 ? $now->year + 1 : $now->year;
        $adjustedStartYear = $start->month >= 7 ? $start->year + 1 : $start->year;

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

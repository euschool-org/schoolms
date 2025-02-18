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

    public function currentFee()
    {
        $startDate = now()->subYears(now()->month <= 6 ? 1 : 0)->startOfYear()->setMonth(7)->startOfMonth();
        $endDate = now();
        $oneYearAfterStart = $startDate->copy()->addYear();

        // Get the first extra record after endDate but within allowed range
        $extraRecord = MonthlyFee::where('month', '>', $endDate)
            ->where('month', '<=', $oneYearAfterStart)
            ->orderBy('month')
            ->first();

        // Get the last month value (either last in range or extra record)
        $lastMonthRecord = MonthlyFee::whereBetween('month', [$startDate, $endDate])
            ->orderByDesc('month')
            ->first();

        $lastMonthValue = $extraRecord ? $extraRecord->month : ($lastMonthRecord ? $lastMonthRecord->month : null);

        // Fetch the sum directly instead of using loadSum()
        $currentFee = $this->monthly_fees()
            ->whereBetween('month', [$startDate, $endDate])
            ->when($extraRecord, fn($query) => $query->orWhere('month', $extraRecord->month))
            ->sum('fee');

        return [
            'amount' => $currentFee,
            'date' => $lastMonthValue,
        ];
    }
    public function yearlyFee($invoice = false)
    {
        // Determine the school year based on the invoice flag
        $schoolYear = $invoice
            ? now()->year . '-' . (now()->year + 1)
            : (now()->month > 6 ? now()->year . '-' . (now()->year + 1) : (now()->year - 1) . '-' . now()->year);

        // Directly fetch the sum instead of using loadSum()
        return $this->monthly_fees()
            ->where('school_year', $schoolYear)
            ->sum('fee');
    }

    public function eligibleToDiscount()
    {
        return true;
    }
    public function year_payment()
    {
        $schoolYear = now()->month > 6
            ? now()->startOfYear()->setMonth(7)->startOfMonth()
            : now()->subYear()->startOfYear()->setMonth(7)->startOfMonth();

        return $this->payments()
            ->where('payment_date', '>', $schoolYear)
            ->sum('nominal_amount');
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

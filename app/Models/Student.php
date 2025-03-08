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
        'first_parent_name',
        'first_parent_mail',
        'first_parent_number',
        'second_parent_name',
        'second_parent_mail',
        'second_parent_number',
        'additional_information',
        'contract_start_date',
        'contract_end_date',
        'currency_id',
        'parent_account',
        'income_account',
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
        $extraRecord = $this->monthly_fees()->where('month', '>', now())
            ->orderBy('month')
            ->first();

        $currentFee = $this->monthly_fees()
            ->where('school_year', 'LIKE','%'.($this->balance_change_year + 1).'%')
            ->where('month', '<=', now())
            ->sum('fee');

        $fee = $extraRecord->fee ?? 0;
        $debt = $currentFee + $this->last_year_balance - $this->year_payment();
        $next = $this->eligibleToDiscount() ? $fee * 0.95 : $fee;

        return [
            'debt' => $debt,
            'next' => $next,
            'amount' => ($debt + $next) > 0 ? $debt + $next : 0,
            'date' => $extraRecord->month ?? null,
        ];
    }
    public function yearlyFee($advance = false)
    {
        // Determine the school year based on the invoice flag
        $schoolYear = $advance
            ? now()->year . '-' . (now()->year + 1)
            : (now()->month > 6 ? now()->year . '-' . (now()->year + 1) : (now()->year - 1) . '-' . now()->year);

        // Directly fetch the sum instead of using loadSum()
        return $this->monthly_fees()
            ->where('school_year', $schoolYear)
            ->sum('fee');
    }

    public function eligibleToDiscount()
    {
        $schoolYear = now()->year . '-' . (now()->year + 1);
        $month = now()->month;
        $mayFee = $this->monthly_fees()->where('month', now()->year . '-05-31')->first()->fee;
        if ($month < 6 || $month > 9 || $this->payment_quantity($schoolYear) != 2 || !$mayFee){
            return false;
        }
        $startDate = now()->setMonth(6)->startOfMonth();
        $endDate = now()->setMonth(6)->endOfMonth();
        $this->loadSum(['payments as june_payments' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('payment_date', [$startDate, $endDate]);
        }], 'nominal_amount');
        if ($month > 6) {
            return $mayFee + $this->last_year_balance + $this->june_payments < 0 ;
        } else {
            $this->loadSum(['payments as year_payments' => function ($query){
                $query->whereBetween('payment_date', [now()->subYear()->month(7)->startOfMonth(), now()->month(5)->endOfMonth()]);
            }], 'nominal_amount');

            return $this->yearlyFee() + $this->last_year_balance + $mayFee - $this->year_payments < 0 ;
        }

    }

    public function payment_quantity($schoolYear)
    {
        $this->loadCount(['monthly_fees as payment_quantity' => function ($query) use ($schoolYear) {
            $query->where('school_year', $schoolYear);
        }]);

        return $this->payment_quantity;
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

<?php

namespace App\Console\Commands;

use App\Models\Payment;
use App\Models\Student;
use Illuminate\Console\Command;

class NewMemberDiscount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:new-member-discount';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '10% discount for new members';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $students = Student::where('new_student_discount', 1)
            ->whereDoesntHave('payments', function ($query) {
                $query->whereYear('payment_date', now()->year)
                    ->where('payment_type', '>', 0);
            })
            ->withSum(['monthly_fees as year_fee' => function ($query) {
                $query->where('school_year', now()->year . '-' . (now()->year + 1));
            }], 'fee')
            ->withSum(['payments as apr_may_calc' => function ($query) {
                $query->whereBetween('payment_date', [
                    now()->startOfYear()->setMonth(4)->startOfMonth(),
                    now()->startOfYear()->setMonth(5)->endOfMonth()
                ]);
            }], 'nominal_amount')
            ->get();
        foreach ($students as $student) {
            if ($student->apr_may_calc >= $student->year_fee * 0.9) {
                Payment::create([
                    'student_id' => $student->id,
                    'payment_date' => now()->toDateTimeString(),
                    'payment_amount' => $student->year_fee * 0.1 * $student->currency->rate_to_gel,
                    'nominal_amount' => $student->year_fee * 0.1,
                    'percentage' => 10,
                    'currency_rate' => $student->currency->rate_to_gel,
                    'payment_type' => 2,
                ]);
            }
        }
    }
}

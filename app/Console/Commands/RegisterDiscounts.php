<?php

namespace App\Console\Commands;

use App\Models\Payment;
use App\Models\Student;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class RegisterDiscounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:register-discounts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register discounts for students';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = now();
        if (!($now->month === 9 && $now->day === 1 && $now->hour === 0)) {
            $this->info('Discount Task skipped: Outside the allowed time range.');
            return CommandAlias::SUCCESS;
        }
        $students = Student::whereNot(function ($query) {
            $query->where(function ($query) {
                $query->where('sector', 'ქართული')->where('current_grade', 12);
            })->orWhere(function ($query) {
                $query->whereIn('sector', ['IB', 'ASAS'])->whereIn('current_grade', [11, 12]);
            });
        })->whereDoesntHave('payments', function ($query) {
            $query->whereYear('payment_date', now()->year)->where('payment_type', '>', 0);
            })->with('currency')->withSum(['payments as before_calc' => function ($query) {
                $query->whereBetween('payment_date', [
                    now()->setMonth(6)->startOfMonth(), // June 1st, current year
                    now()->setMonth(6)->endOfMonth()   // june 31st, current year
                ]);
            }],'nominal_amount')->withSum(['payments as after_calc' => function ($query) {
                $query->whereBetween('payment_date', [
                    now()->setMonth(7)->startOfMonth(), // july 1st, current year
                    now()->setMonth(8)->endOfMonth()   // August 31st, current year
                ]);
            }],'nominal_amount')->withSum(['monthly_fees as year_fee' => function ($query) {
                $query->where('school_year', now()->year.'-'.now()->year+1);
            }],'fee')->get();

        foreach ($students as $student) {
            $balance_before_may = -$student->last_year_balance - $student->before_calc;
            $balance_till_august = -$student->last_year_balance + $student->after_calc;
            if ($balance_before_may > ($student->year_fee * 0.5) && $balance_till_august > ($student->year_fee * 0.95)) {
                Payment::create([
                    'student_id' => $student->id,
                    'payment_date' => now()->setMonth(9)->startOfMonth(),
                    'payment_amount' => $student->year_fee * 0.05 * $student->currency->rate_to_gel,
                    'nominal_amount' => $student->year_fee * 0.05,
                    'percentage' => 5,
                    'currency_rate' => $student->currency->rate_to_gel,
                    'payment_type' => 1,
                ]);
            }
        }

        $this->info('Task executed successfully.');
        return Command::SUCCESS;
    }
}

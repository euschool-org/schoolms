<?php

namespace App\Console\Commands;

use App\Models\Student;
use Illuminate\Console\Command;

class CalculateBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:calculate-balance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate Last Year Balance';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (now()->month != 8){
            return;
        }
        $students = Student::withSum(['payments as total_payments' => function ($query) {
            $startDate = now()->subYear()->startOfYear()->addMonths(7);
            $endDate = now()->startOfYear()->addMonths(6)->endOfMonth();
            $query->whereBetween('payment_date', [$startDate, $endDate]);
        }], 'nominal_amount')->get();

        foreach ($students as $student) {
            if ($student->balance_change_year != now()->year) {
                $student->last_year_balance  = $student->last_year_balance + $student->total_payments - $student->yearly_payment;
                $student->balance_change_year = now()->year;
                $student->save();
            }
        }
    }
}

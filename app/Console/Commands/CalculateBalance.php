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
        $now = now();
//        if ($now->month != 7 || $now->day != 1){
//            $this->info('Balance Task skipped: Outside the allowed time range.');
//            return Command::SUCCESS;
//        }
        $students = Student::withSum(['payments as total_payments' => function ($query) {
            $startDate = now()->subYear()->startOfYear()->setMonth(7)->startOfMonth();
            $endDate = now()->startOfYear()->setMonth(6)->endOfMonth();
            $query->whereBetween('payment_date', [$startDate, $endDate]);
        }], 'nominal_amount')->withSum(['monthly_fees as last_year_fee' => function ($query) {
            $query->where('school_year', now()->subYear()->year . '-' . now()->year);
        }], 'fee')->get();
        foreach ($students as $student) {
            if ($student->balance_change_year != now()->year) {
                $student->last_year_balance  = $student->last_year_fee + $student->last_year_balance - $student->total_payments;
                $student->balance_change_year = now()->year;
                $student->current_grade = $student->grade_label;
                $student->save();
            }
        }
    }
}

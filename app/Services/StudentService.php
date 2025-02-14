<?php

namespace App\Services;

use App\Models\AnnualFee;
use App\Models\MonthlyFee;
use App\Models\Student;
use Carbon\Carbon;

class StudentService
{
    public function getStudents($request)
    {
        $data = [];
        $startDatePayments = now()->setMonth(7)->startOfMonth()->subYears(now()->month <= 6 ? 1 : 0);
        $endDatePayments = now()->setMonth(6)->endOfMonth()->addYears(now()->month > 6 ? 1 : 0);
        $query = Student::withSum([
            'payments as yearly_payments_sum' => function ($query) use ($startDatePayments, $endDatePayments) {
                $query->whereBetween('payment_date', [$startDatePayments, $endDatePayments])->where('payment_type', 0);
            }], 'nominal_amount')->withSum([
            'payments as yearly_5p_discounts_sum' => function ($query) use ($startDatePayments, $endDatePayments) {
                $query->whereBetween('payment_date', [$startDatePayments, $endDatePayments])->where('payment_type', 1);
            }], 'nominal_amount')->withSum([
            'payments as yearly_10p_discounts_sum' => function ($query) use ($startDatePayments, $endDatePayments) {
                $query->whereBetween('payment_date', [$startDatePayments, $endDatePayments])->where('payment_type', 2);
            }], 'nominal_amount')->withSum([
            'payments as yearly_individual_discounts_sum' => function ($query) use($startDatePayments, $endDatePayments) {
                $query->whereBetween('payment_date', [$startDatePayments, $endDatePayments])->where('payment_type', 3);
            }], 'nominal_amount')->withSum([
            'monthly_fees as first_half_fee' => function ($query){
                $startDate = now()->subYears(now()->month <= 6 ? 1 : 0)->startOfYear()->setMonth(9)->startOfMonth();
                $endDate = now()->addYears(now()->month > 6 ? 1 : 0)->startOfYear()->endOfMonth();

                $query->whereBetween('month', [$startDate, $endDate]);
            }], 'fee')->withSum(
            [
                'monthly_fees as second_half_fee' => function ($query){
                    $startDate = now()->startOfYear()->addYears(now()->month > 6 ? 1 : 0)->endOfMonth();
                    $endDate = now()->startOfYear()->addYears(now()->month > 6 ? 1 : 0)->setMonth(6)->endOfMonth();

                    $query->whereBetween('month', [$startDate, $endDate]);
                },
            ],'fee')->with('monthly_fees')->with('currency');
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->filled('private_number')) {
            $query->where('private_number', 'like', '%' . $request->input('private_number') . '%');
        }

        if ($request->filled('grade')) {
            $query->whereIn('grade', $request->input('grade'));
        }

        if ($request->filled('group')) {
            $query->whereIn('group', $request->input('group'));
        }

        if ($request->filled('sector')) {
            $query->whereIn('sector', $request->input('sector'));
        }

        if ($request->filled('parent_name')) {
            $query->where('parent_name', 'like', '%' . $request->input('parent_name') . '%');
        }

        if ($request->filled('parent_mail')) {
            $query->where('parent_mail', 'like', '%' . $request->input('parent_mail') . '%');
        }

        if ($request->filled('parent_number')) {
            $query->where('parent_number', 'like', '%' . $request->input('parent_number') . '%');
        }

        if ($request->filled('pupil_status')) {
            $pupilStatus = $request->input('pupil_status');

            $query->where(function ($query) use ($pupilStatus) {
                $now = Carbon::now();

                if (in_array('active', $pupilStatus)) {
                    // Add condition for 'active', including cases where contract_end_date is null
                    $query->orWhere(function ($query) use ($now) {
                        $query->whereDate('contract_start_date', '<=', $now)
                            ->where(function ($query) use ($now) {
                                $query->whereDate('contract_end_date', '>=', $now)
                                    ->orWhereNull('contract_end_date');
                            });
                    });
                }

                if (in_array('past', $pupilStatus)) {
                    // Add condition for 'past'
                    $query->orWhere(function ($query) use ($now) {
                        $query->whereDate('contract_end_date', '<', $now);
                    });
                }

                if (in_array('future', $pupilStatus)) {
                    // Add condition for 'future'
                    $query->orWhere(function ($query) use ($now) {
                        $query->whereDate('contract_start_date', '>', $now);
                    });
                }
            });
        }

        if ($request->filled('additional_information')) {
            $query->where('additional_information', 'like', '%' . $request->input('additional_information') . '%');
        }

        if ($request->filled('contract_start_date')) {
            $contractStartDates = explode(' to ', $request->input('contract_start_date'));
            if (isset($contractStartDates[0])) {
                $query->where('contract_start_date', '>=', $contractStartDates[0]);
            }
            if (isset($contractStartDates[1])) {
                $query->where('contract_start_date', '<=', $contractStartDates[1]);
            }
        }

        if ($request->filled('contract_end_date')) {
            $contractEndDates = explode(' to ', $request->input('contract_end_date'));
            if (isset($contractEndDates[0])) {
                $query->where('contract_end_date', '>=', $contractEndDates[0]);
            }
            if (isset($contractEndDates[1])) {
                $query->where('contract_end_date', '<=', $contractEndDates[1]);
            }
        }

//        if ($request->filled('payment_schedule')) {
//            $paymentSchedule = explode(' to ', $request->input('payment_schedule'));
//            if (isset($paymentSchedule[0])) {
//                $query->where('payment_schedule', '>=', $paymentSchedule[0]);
//            }
//            if (isset($paymentSchedule[1])) {
//                $query->where('payment_schedule', '<=', $paymentSchedule[1]);
//            }
//        }

        if ($request->filled('yearly_payment_from')) {
            $query->having('yearly_payments_sum', '>=', $request->input('yearly_payment_from'));
        }

        if ($request->filled('yearly_payment_to')) {
            $query->having('yearly_payments_sum', '<=', $request->input('yearly_payment_to'));
        }

        if ($request->filled('currency')) {
            $query->whereHas('currency', function ($q) use ($request) {
                $q->whereIn('code', $request->input('currency'));
            });
        }

        if ($request->filled('parent_account')) {
            $query->where('parent_account', $request->input('parent_account'));
        }

        if ($request->filled('income_account')) {
            $query->where('income_account', $request->input('income_account'));
        }

        if ($request->filled('payment_quantity')) {
            $query->where('payment_quantity', $request->input('payment_quantity'));
        }

        if ($request->filled('custom_discount')) {
            $query->where('custom_discount', $request->input('custom_discount'));
        }

        $perPage = $request->get('per_page', 10);
        $students = $query->paginate($perPage);
        $totalStudents = $students->total();

        $students->each(function ($student) {
            $student->yearly_fee = $student->first_half_fee + $student->second_half_fee;
            $total_discounts = $student->yearly_5p_discounts_sum + $student->yearly_10p_discounts_sum + $student->yearly_individual_discounts_sum;
            $yearly_payment_sum = $student->yearly_payments_sum + $total_discounts ?? 0;

            $student->debt = max($student->last_year_balance - $yearly_payment_sum, 0);

            $yearly_payment_sum = max($yearly_payment_sum - $student->last_year_balance,0);
            $student->first_half =max($student->first_half_fee - $yearly_payment_sum, 0);

            $yearly_payment_sum = max($yearly_payment_sum - $student->first_half_fee,0);
            $student->second_half = $student->second_half_fee - $yearly_payment_sum;
        });
        // Return the students and total count
        $data['students'] = $students;
        $data['total_students'] = $totalStudents;

        return $data;
    }

    public function syncStudentFees($student)
    {
        if (!$student->contract_start_date || !$student->contract_end_date) {
            return;
        }
        $contractStart = Carbon::parse($student->contract_start_date);
        $contractEnd   = Carbon::parse($student->contract_end_date);

        $data = [];
        $startSchoolYear = $contractStart->month >= 9 ? $contractStart->year : $contractStart->year - 1;
        $endSchoolYear   = $contractEnd->month >= 9   ? $contractEnd->year   : $contractEnd->year - 1;

        for ($year = $startSchoolYear; $year <= $endSchoolYear; $year++) {
            $schoolYear = $year . '-' . ($year + 1);
            $mayFeeDate = Carbon::createFromFormat('Y-m-d', $year . '-05-31');
            $decFeeDate = Carbon::createFromFormat('Y-m-d', $year . '-12-15');

            if ($mayFeeDate->between($contractStart, $contractEnd, true)) {
                $data[] = [
                    'student_id'  => $student->id,
                    'month'       => $mayFeeDate->toDateString(),  // Stored as "YYYY-MM-DD"
                    'school_year' => $schoolYear,
                ];
            }
            if ($decFeeDate->between($contractStart, $contractEnd, true)) {
                $data[] = [
                    'student_id'  => $student->id,
                    'month'       => $decFeeDate->toDateString(),
                    'school_year' => $schoolYear,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ];
            }
        }

        if (!empty($data)) {
            MonthlyFee::where('student_id', $student->id)
                ->whereNotBetween('month', [
                    $contractStart->copy()->startOfMonth()->toDateString(),
                    $contractEnd->copy()->endOfMonth()->toDateString(),
                ])
                ->delete();

            MonthlyFee::upsert($data, ['student_id', 'month'], ['school_year', 'updated_at']);
        }
    }
    public function defaultMonths($quantity, $schoolYear)
    {
        // Extract the first year from the school year (e.g., 2025 from 2025-2026)
        $startYear = substr($schoolYear, 0, 4);

        $months = [];

        // If quantity is 1, return May 31st of the start year
        if ($quantity == 1) {
            $months[] = "{$startYear}-05-31";  // Format: YYYY-MM-DD
        }

        // If quantity is 2, return May 31st and December 15th of the start year
        elseif ($quantity == 2) {
            $months[] = "{$startYear}-05-31";  // Format: YYYY-MM-DD
            $months[] = "{$startYear}-12-15";  // Format: YYYY-MM-DD
        }

        // If quantity is 10, return the 15th of each month from September to June (spanning two years)
        elseif ($quantity == 10) {
            $startDate = strtotime("1-Sep-{$startYear}");
            for ($i = 0; $i < 10; $i++) {
                // Calculate the 15th of each month in the range from September to June
                $months[] = date("Y-m-d", strtotime("15-" . date("M-Y", strtotime("+$i month", $startDate))));
            }
        }

        return $months;
    }


}

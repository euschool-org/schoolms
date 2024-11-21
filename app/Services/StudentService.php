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
        $query = Student::withSum([
            'payments as yearly_payments_sum' => function ($query) {
                if (now()->month >= 8) {  // August or later
                    $startDate = now()->startOfYear()->addMonths(7);
                    $endDate = now()->startOfYear()->addYear()->addMonths(6)->endOfMonth();
                } else {
                    $startDate = now()->subYear()->startOfYear()->addMonths(7);
                    $endDate = now()->startOfYear()->addMonths(6)->endOfMonth();
                }

                $query->whereBetween('payment_date', [$startDate, $endDate]);
            }], 'nominal_amount')->withSum([
            'monthly_fees as first_half_fee' => function ($query){
                if (now()->month >= 8) {
                    $startDate = now()->startOfYear()->addMonths(8);
                    $endDate = now()->startOfYear()->addYear()->endOfMonth();
                } else {
                    $startDate = now()->subYear()->startOfYear()->addMonths(8);
                    $endDate = now()->startOfYear()->endOfMonth();
                }

                $query->whereBetween('month', [$startDate, $endDate]);
            }], 'fee')->withSum(
            [
                'monthly_fees as second_half_fee' => function ($query){
                    if (now()->month >= 8) {
                        $startDate = now()->startOfYear()->addYear()->endOfMonth();
                        $endDate = now()->startOfYear()->addYear()->addMonths(7);
                    } else {
                        $startDate = now()->startOfYear()->endOfMonth();
                        $endDate = now()->startOfYear()->addMonths(7);
                    }

                    $query->whereBetween('month', [$startDate, $endDate]);
                },
            ],'fee')->with('monthly_fees');
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

        if ($request->filled('payment_schedule')) {
            $paymentSchedule = explode(' to ', $request->input('payment_schedule'));
            if (isset($paymentSchedule[0])) {
                $query->where('payment_schedule', '>=', $paymentSchedule[0]);
            }
            if (isset($paymentSchedule[1])) {
                $query->where('payment_schedule', '<=', $paymentSchedule[1]);
            }
        }

        if ($request->filled('yearly_payment_from')) {
            $query->where('yearly_payment', '>=', $request->input('yearly_payment_from'));
        }

        if ($request->filled('yearly_payment_to')) {
            $query->where('yearly_payment', '<=', $request->input('yearly_payment_to'));
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
        $totalQuery = clone $query;
        $totalStudents = $totalQuery->count();

        // Paginate the query
        $perPage = $request->get('per_page', 10);
        $students = $query->paginate($perPage);

        $students->each(function ($student) {
            $student->yearly_fee = $student->first_half_fee + $student->second_half_fee;;
            $yearly_payment_sum = $student->yearly_payments_sum ?? 0;

            $student->debt = max($student->last_year_balance - $yearly_payment_sum, 0);

            $yearly_payment_sum -= $student->last_year_balance;
            $student->first_half = max($student->first_half_fee - $yearly_payment_sum, 0);

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
            return ;
        }
        $startDate = Carbon::parse($student->contract_start_date);
        $endDate = Carbon::parse($student->contract_end_date);

        while ($startDate <= $endDate) {
            if ($startDate->month == 7 || $startDate->month == 8) {
                $startDate->addMonth();
                continue;
            }
            $currentYear = $startDate->year;
            $nextYear = $startDate->month >= 9 ? $currentYear + 1 : $currentYear;
            $schoolYear = $startDate->month >= 9 ? "$currentYear-$nextYear" : ($currentYear - 1) . "-$currentYear";

            MonthlyFee::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'month' => $startDate->startOfMonth(),
                    'school_year' => $schoolYear,
                ],
            );
            $startDate->addMonth();
        }
    }
}

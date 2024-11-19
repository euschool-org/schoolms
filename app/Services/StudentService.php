<?php

namespace App\Services;

use App\Models\AnnualFee;
use App\Models\Student;
use Carbon\Carbon;

class StudentService
{
    public function getStudents($request)
    {
        $data = [];
        $query = Student::withSum(['payments as yearly_payments_sum' => function ($query) {
            if (now()->month >= 8) {  // August or later
                $startDate = now()->startOfYear()->addMonths(7);
                $endDate = now()->startOfYear()->addYear()->addMonths(6)->endOfMonth();
            } else {
                $startDate = now()->subYear()->startOfYear()->addMonths(7);
                $endDate = now()->startOfYear()->addMonths(6)->endOfMonth();
            }

            $query->whereBetween('payment_date', [$startDate, $endDate]);
        }], 'nominal_amount');
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
            $student->debt = min($student->last_year_balance + $student->yearly_payments_sum, 0);

            $student->first_half = min($student->monthly_payment*5 + $student->yearly_payments_sum, 0);
            $student->second_half = min($student->monthly_payment*5 + $student->yearly_payments_sum, 0);
        });
        // Return the students and total count
        $data['students'] = $students;
        $data['total_students'] = $totalStudents;

        return $data;
    }

    public function syncStudentFees($student)
    {
        $startYear = Carbon::parse($student->contract_start_date)->year;
        $startMonth = Carbon::parse($student->contract_start_date)->month;
        $endYear = Carbon::parse($student->contract_end_date)->year;
        $endMonth = Carbon::parse($student->contract_end_date)->month;

        if ($startMonth < 6) {
            $startYear--;
        }
        if ($endMonth < 9) {
            $endYear--;
        }

        $validYears = range($startYear, $endYear);

        $existingYears = AnnualFee::where('student_id', $student->id)
            ->pluck('year')
            ->toArray();

        $yearsToAdd = array_diff($validYears, $existingYears);

        $yearsToRemove = array_diff($existingYears, $validYears);

        foreach ($yearsToAdd as $year) {
            AnnualFee::create([
                'student_id' => $student->id,
                'display_year' => $year.'-'.($year+1),
                'year' => $year,
                'fee' => 0
            ]);
        }

        AnnualFee::where('student_id', $student->id)
            ->whereIn('year', $yearsToRemove)
            ->delete();
    }
}

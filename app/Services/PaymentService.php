<?php

namespace App\Services;

use App\Models\AnnualFee;
use App\Models\Payment;
use App\Models\Student;
use Carbon\Carbon;

class PaymentService
{

    public function createPayment($student, $data)
    {
        $data['student_id'] = $student->id;
        $data['currency_rate'] = $student->currency->rate_to_gel;
        $data['nominal_amount'] = $data['payment_amount']/$data['currency_rate'];
        $data['percentage'] = $data['nominal_amount']/$student->yearlyFee() * 100;
//        try {
            return Payment::create($data);
//        } catch (\Exception $e) {
//            return false;
//        }
    }
    public function createDiscount($student)
    {
        $year = now()->month > 8 ? now()-$this->paymentService->createPayment($student, $request->validated())>year : now()->subYear()->year;
        $startDate = Carbon::create($year, 8,1);
        $endDate = Carbon::create($year+1, 7,31);
        $student->loadSum(['monthly_fees as current_year_fee' => function ($query) use ($year) {
            $query->where('school_year', $year.'-'.$year+1);
        }],'fee')->loadSum(['monthly_fees as next_year_fee' => function ($query) use ($year) {
            $query->where('school_year', $year+1 . '-' . $year+2);
        }],'fee')->loadSum(['payments as current_year_payments' => function ($query) use ($year, $startDate, $endDate) {
            $query->whereBetween('payment_date', [$startDate, $endDate])->where('payment_type',0);
        }],'nominal_amount')->load(['payments' => function ($query) use ($year, $startDate, $endDate) {
            $query->whereBetween('payment_date', [$startDate, $endDate])->where('payment_type', '!=', '0');
        }]);

        $data = $this->getDiscount($student);
        $data['student_id'] = $student->id;
        $data['payment_date'] = now()->toDateString();

    }

    public function getDiscount($student)
    {
        $data = [];
        if ($student->custom_discount){
            $data['payment_amount'] = $student->custom_discount;
            $data['percentage'] = ($student->custom_discount/$student->next_year_fee)*100;
            $data['payment_type'] = 3;
        } elseif ($student->new_student_discount && now()->month < 6 && now()->day < 20 ){
            $currenct_year_balance = $student->current_year_payments - $student->last_year_balance - $student->current_year_fee;
            $percentage = $currenct_year_balance * 100 / $student->next_year_fee;
            if ($percentage >= 90){
                $data['payment_amount'] = $student->next_year_fee/10;
                $data['percentage'] = 10;
                $data['payment_type'] = 2;
            }
        } else{
            $data['payment_amount'] = $student->next_year_fee/10;
            $data['percentage'] = 10;
            $data['payment_type'] = 2;
        }
        return $data;
    }
}

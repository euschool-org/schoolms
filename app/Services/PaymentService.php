<?php

namespace App\Services;

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
        $data['percentage'] = $student->yearlyFee() ? $data['nominal_amount']/$student->yearlyFee() * 100 : null;
        try {
            return Payment::create($data);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function importPayment($student, $payment, $type = 0)
    {
        $data = [
            'payment_date' => now(),
            'payment_amount' => $payment,
            'payment_type' => $type,
            'description' => 'იმპორტირებული',
        ];

        return $this->createPayment($student, $data);
    }
}

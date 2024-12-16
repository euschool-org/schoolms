<?php

namespace App\Services;

use App\Models\Attachment;
use App\Models\Student;
use Illuminate\Support\Facades\Storage;

class NotificationService
{
    public function getStudentsToNotify($selectedGroups, $sendEmail = false, $sendSms = false)
    {
        // Start the query
        $query = Student::where('email_notifications', 1);
        $startDatePayments = now()->setMonth(7)->startOfMonth()->subYears(now()->month <= 6 ? 1 : 0);
        $endDatePayments = now()->setMonth(6)->endOfMonth()->addYears(now()->month > 6 ? 1 : 0);


        if ($selectedGroups) {
            $query->withSum([
                'payments as yearly_payments_sum' => function ($query) use ($startDatePayments, $endDatePayments) {
                    $query->whereBetween('payment_date', [$startDatePayments, $endDatePayments]);
                }], 'nominal_amount')
                ->withSum(['monthly_fees as first_half_fee' => function ($query){
                        $startDate = now()->subYears(now()->month <= 6 ? 1 : 0)->startOfYear()->setMonth(9)->startOfMonth();
                        $endDate = now()->addYears(now()->month > 6 ? 1 : 0)->startOfYear()->endOfMonth();

                        $query->whereBetween('month', [$startDate, $endDate]);
                    }], 'fee')
                ->withSum(['monthly_fees as second_half_fee' => function ($query){
                    $startDate = now()->startOfYear()->addYears(now()->month > 6 ? 1 : 0)->endOfMonth();
                    $endDate = now()->startOfYear()->addYears(now()->month > 6 ? 1 : 0)->setMonth(6)->endOfMonth();
                    $query->whereBetween('month', [$startDate, $endDate]);
                        },
                ],'fee');
            if (in_array('prev_year', $selectedGroups)) {
                $query->havingRaw('(last_year_balance - yearly_payments_sum) > 0');
            }
            if (in_array('semester_1', $selectedGroups)) {
                $query->orHavingRaw('(last_year_balance + first_half_fee - yearly_payments_sum) > 0');
            }
            if (in_array('semester_2', $selectedGroups)) {
                $query->orHavingRaw('(last_year_balance + first_half_fee + second_half_fee - yearly_payments_sum) > 0');
            }
            if (in_array('monthly_reminder', $selectedGroups)) {
                $query->orWhere('payment_quantity',10);
            }
        }

        // If we need to send email, filter students who have an email
        if ($sendEmail && !$sendSms) {
            $query->whereNotNull('parent_mail'); // Only students with email
        }

        // If we need to send SMS, filter students who have a phone number
        if (!$sendEmail && $sendSms) {
            dd(1);
            $query->whereNotNull('parent_number'); // Only students with a phone number
        }

        // If we need to send both email and SMS, filter students who have both
        if ($sendEmail && $sendSms) {
            dd(1);
            $query->whereNotNull('email')
                ->orWhereNotNull('phone_number'); // Students who have both email and phone number
        }

        // Execute the query and return the result
        return $query->get();
    }

}

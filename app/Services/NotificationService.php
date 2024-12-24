<?php

namespace App\Services;

use App\Models\Attachment;
use App\Models\Student;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class NotificationService
{
    public function getStudentsToNotify($selectedGroups, $sendEmail = false, $sendSms = false)
    {
        // Define date ranges for payments and fees
        $startDatePayments = now()->setMonth(7)->startOfMonth()->subYears(now()->month <= 6 ? 1 : 0);
        $endDatePayments = now()->setMonth(6)->endOfMonth()->addYears(now()->month > 6 ? 1 : 0);

        $firstHalfFeeStart = now()->subYears(now()->month <= 6 ? 1 : 0)->startOfYear()->setMonth(9)->startOfMonth();
        $firstHalfFeeEnd = now()->addYears(now()->month > 6 ? 1 : 0)->startOfYear()->endOfMonth();

        $secondHalfFeeStart = now()->startOfYear()->addYears(now()->month > 6 ? 1 : 0)->endOfMonth();
        $secondHalfFeeEnd = now()->startOfYear()->addYears(now()->month > 6 ? 1 : 0)->setMonth(6)->endOfMonth();

        // Start the query with the mandatory filter
        $query = Student::query();

        // Add sums for payments and fees
        $query->withSum(['payments as yearly_payments_sum' => function ($query) use ($startDatePayments, $endDatePayments) {
            $query->whereBetween('payment_date', [$startDatePayments, $endDatePayments]);
        }], 'nominal_amount')
            ->withSum(['monthly_fees as first_half_fee' => function ($query) use ($firstHalfFeeStart, $firstHalfFeeEnd) {
                $query->whereBetween('month', [$firstHalfFeeStart, $firstHalfFeeEnd]);
            }], 'fee')
            ->withSum(['monthly_fees as second_half_fee' => function ($query) use ($secondHalfFeeStart, $secondHalfFeeEnd) {
                $query->whereBetween('month', [$secondHalfFeeStart, $secondHalfFeeEnd]);
            }], 'fee');

        $query->where('email_notifications', 1)->having(function ($q) use ($selectedGroups) {
            if (in_array('prev_year', $selectedGroups)) {
                $q->havingRaw('(last_year_balance - yearly_payments_sum) > 0');
            }
            if (in_array('semester_1', $selectedGroups)) {
                $q->orHavingRaw('(last_year_balance + first_half_fee - yearly_payments_sum) > 0');
            }
            if (in_array('semester_2', $selectedGroups)) {
                $q->orHavingRaw('(last_year_balance + first_half_fee + second_half_fee - yearly_payments_sum) > 0');
            }
            if (in_array('monthly_reminder', $selectedGroups)) {
                $q->orHavingRaw('payment_quantity = 10');
            }
        });

        $query->where(function ($q) use ($sendEmail, $sendSms) {
            if ($sendEmail) {
                $q->whereNotNull('parent_mail');
            }
            if ($sendSms) {
                $q->orWhereNotNull('parent_number');
            }
        });

        // Execute and return the result
        return $query->get();
    }

    public static function sendSms($destination, $content)
    {
        $fields = [
            'apikey' => env('SENDER_APIKEY'),
            'smsno' => 2,
            'destination' => $destination,
            'content' => $content,
        ];
        $fields_string = http_build_query($fields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        // Return the response or its status

    }

}

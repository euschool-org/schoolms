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
        $schoolYear = $startDatePayments->year . '-' . $endDatePayments->year;

        $query = Student::query()->withSum(['payments as yearly_payments_sum' => function ($query) use ($startDatePayments, $endDatePayments) {
            $query->whereBetween('payment_date', [$startDatePayments, $endDatePayments]);
        }], 'nominal_amount')
            ->withSum(['monthly_fees as yearly_fee' => function ($query) use ($schoolYear) {
                $query->where('school_year', $schoolYear);
            }], 'fee')
            ->withCount(['monthly_fees as payment_quantity' => function ($query) use ($schoolYear) {
                $query->where('school_year', $schoolYear);
            }]);

        $query->where('email_notifications', 1)->having(function ($q) use ($selectedGroups) {
            if (in_array('prev_year', $selectedGroups)) {
                $q->havingRaw('(COALESCE(last_year_balance, 0) - COALESCE(yearly_payments_sum, 0)) > 0');
            }
            if (in_array('semester_1', $selectedGroups)) {
                $q->orHavingRaw('(COALESCE(last_year_balance, 0) + (COALESCE(yearly_fee, 0)/2) - COALESCE(yearly_payments_sum, 0)) > 0');
            }
            if (in_array('semester_2', $selectedGroups)) {
                $q->orHavingRaw('(COALESCE(last_year_balance, 0) + COALESCE(yearly_fee, 0) - COALESCE(yearly_payments_sum, 0)) > 0');
            }
            if (in_array('monthly_reminder', $selectedGroups)) {
                $q->orHavingRaw('COALESCE(payment_quantity, 0) = 10');
            }
        });
        dd($query->get());
        $query->where(function ($q) use ($sendEmail, $sendSms) {
            if ($sendEmail) {
                $q->whereNotNull('first_parent_mail')
                    ->orWhereNotNull('second_parent_mail');
            }
            if ($sendSms) {
                $q->orWhere(function ($q2) {
                    $q2->whereNotNull('first_parent_number')
                        ->orWhereNotNull('second_parent_number');
                });
            }
        });

        return $query->get();
    }

    public static function sendSms($destination, $content)
    {
        $url = "https://sender.ge/api/send.php";

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

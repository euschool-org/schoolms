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
        $query = Student::query();

        // If we need to send email, filter students who have an email
        if ($sendEmail && !$sendSms) {
            $query->whereNotNull('email'); // Only students with email
        }

        // If we need to send SMS, filter students who have a phone number
        if (!$sendEmail && $sendSms) {
            $query->whereNotNull('phone_number'); // Only students with a phone number
        }

        // If we need to send both email and SMS, filter students who have both
        if ($sendEmail && $sendSms) {
            $query->whereNotNull('email')
                ->orWhereNotNull('phone_number'); // Students who have both email and phone number
        }

        // Execute the query and return the result
        return $query->get();
    }

}

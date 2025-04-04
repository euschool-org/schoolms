<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendNotificationRequest;
use App\Jobs\SendNotificationJob;
use App\Mail\SendPdfMail;
use App\Models\Student;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;

class NotificationController extends Controller
{
    public $notificationService;
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }
    public function index()
    {
        return view('notifications');
    }

    public function send(SendNotificationRequest $request)
    {
        $data = $request->validated();

        $selectedItems = json_decode($request->input('selected_items'), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException('Invalid JSON in selected_items');
        }

        $students = $this->notificationService->getStudentsToNotify(
            $selectedItems,
            $request->input('email_notification'),
            $request->input('sms_notification')
        );

        $notificationData = [
            'subject' => $data['subject'] ?? null,
            'body' => $data['body'] ?? null,
            'attach_invoice' => $data['attach_invoice'] ?? null,
        ];

        $emailEnabled = $request->input('email_notification');
        $smsEnabled = $request->input('sms_notification');

        foreach ($students as $student) {
            if ($emailEnabled) {
                $emails = array_filter([
                    $student->first_parent_mail ?? null,
                    $student->second_parent_mail ?? null,
                ]);
                foreach ($emails as $email) {
                    Mail::to($email)->send(new SendPdfMail($notificationData, $student));
                }
            }
            if ($smsEnabled) {
                $phoneNumbers = array_filter([
                    $student->first_parent_number ?? null,
                    $student->second_parent_number ?? null,
                ]);
                foreach ($phoneNumbers as $number) {
                    NotificationService::sendSms($number, $notificationData['body']);
                }
            }
        }

//        $chunkSize = 250; // Daily email limit
//        $chunks = collect($students)->chunk($chunkSize);
//
//        $currentDay = now()->startOfDay();
//
//        foreach ($chunks as $chunk) {
//            $quota = $this->getRemainingQuotaForDay($currentDay);
//
//            if ($quota <= 0) {
//                $currentDay = $currentDay->addDay();
//                $quota = $this->getRemainingQuotaForDay($currentDay);
//            }
//
//            $emailsToSend = $chunk->take($quota);
//            $remainingEmails = $chunk->slice($quota);
//            Queue::later(
//                $currentDay,
//                new SendNotificationJob($students, $notificationData, $emailEnabled, $smsEnabled);
//            );
//
//            $this->incrementQuotaForDay($currentDay, $emailsToSend->count());
//
//            if ($remainingEmails->isNotEmpty()) {
//                $chunks->prepend($remainingEmails);
//            }
//        }

        return redirect()->back()->with('success', 'All notifications have been scheduled.');
    }

    private function getRemainingQuotaForDay($day)
    {
        // Get the number of scheduled emails for the given day
        $quota = \DB::table('daily_email_quota')->where('date', $day->toDateString())->value('emails_scheduled');

        return 250 - ($quota ?? 0); // Return remaining quota
    }

    private function incrementQuotaForDay($day, $count)
    {
        // Increment the scheduled emails for the given day
        DB::table('daily_email_quota')->updateOrInsert(
            ['date' => $day->toDateString()],
            ['emails_scheduled' => \DB::raw("emails_scheduled + $count"), 'updated_at' => now()]
        );
    }

}

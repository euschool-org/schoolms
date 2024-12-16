<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendNotificationRequest;
use App\Jobs\SendNotificationJob;
use App\Mail\SendPdfMail;
use App\Models\Student;
use App\Services\NotificationService;
use Illuminate\Http\Request;
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

        // Extract only primitive data or simple objects that can be serialized
        $notificationData = [
            'subject' => $data['subject'] ?? null,
            'body' => $data['body'] ?? null,
            'attach_invoice' => $data['attach_invoice'] ?? null,
            // Add other serializable data you need
        ];

        $emailEnabled = $request->input('email_notification');
        $smsEnabled = $request->input('sms_notification');
        $chunks = collect($students)->chunk(250);
        foreach ($chunks as $day => $chunk) {
            Queue::later(
                now()->addDays($day),
                new SendNotificationJob($chunk, $notificationData, $emailEnabled, $smsEnabled)
            );
        }
        return redirect()->back()->with('success', 'All notifications have been sent.');
    }

}

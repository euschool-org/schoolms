<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendNotificationRequest;
use App\Mail\SendPdfMail;
use App\Models\Student;
use App\Services\NotificationService;
use Illuminate\Http\Request;
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

        $students = $this->notificationService->getStudentsToNotify(
            json_decode($request->input('selected_items'), true),
            $request->input('email_notification'),
            $request->input('sms_notification')
        );
        // Chunk the students into groups of 250
        $chunks = collect($students)->chunk(250);

        foreach ($chunks as $day => $chunk) {
            // Schedule each chunk with a delay of $day days
            Queue::later(
                now()->addDays($day),
                function () use ($chunk, $data, $request) {
                    foreach ($chunk as $student) {
                        if ($request->input('email_notification') && $student['parent_mail']) {
                            Mail::to($student['parent_mail'])->send(new SendPdfMail($data));
                        }
                        if ($request->input('sms_notification') && $student['parent_number']) {
                            // Send SMS to number
                        }
                    }
                }
            );
        }
    }

}

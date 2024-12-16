<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendNotificationRequest;
use App\Mail\SendPdfMail;
use App\Models\Student;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
            json_decode($request->input('selected_items'),true),
            $request->input('email_notification'),
            $request->input('sms_notification')
        );
        dd($students);
        foreach ($students as $student) {
            if ($request->input('email_notification') && $student->parent_mail) {
                Mail::to($student->parent_mail)->send(new SendPdfMail($data));
            }
            if ($request->input('sms_notification') && $student->parent_number) {
                //send sms to number
            }
        }

        return redirect()->back()->with('success', 'Notification sent');
    }

}

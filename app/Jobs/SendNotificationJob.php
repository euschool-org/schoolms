<?php

namespace App\Jobs;

use App\Mail\SendPdfMail;
use App\Services\NotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $chunk;
    protected $notificationData;
    protected $emailEnabled;
    protected $smsEnabled;

    public function __construct($chunk, $notificationData, $emailEnabled, $smsEnabled)
    {
        $this->chunk = $chunk;
        $this->notificationData = $notificationData;
        $this->emailEnabled = $emailEnabled;
        $this->smsEnabled = $smsEnabled;
    }

    public function handle()
    {
        foreach ($this->chunk as $student) {
            try {
                Log::error($student);
                $this->sendEmails($student);
                $this->sendSms($student);
            } catch (\Exception $e) {
                Log::error("Failed to process notification for student ID: {$student->id}, Error: {$e->getMessage()}");
                $this->fail($e);
            }

        }
    }

    /**
     * Send email notifications to both parents if emails are provided.
     */
    private function sendEmails($student)
    {
        if ($this->emailEnabled) {
            foreach (['first_parent_mail', 'second_parent_mail'] as $emailField) {
                if (!empty($student->$emailField)) {
                    Mail::to($student->$emailField)
                        ->send(new SendPdfMail($this->notificationData, $student));
                }
            }
        }
    }

    /**
     * Send SMS notifications to both parents if phone numbers are provided.
     */
    private function sendSms($student)
    {
        if ($this->smsEnabled) {
            foreach (['first_parent_number', 'second_parent_number'] as $phoneField) {
                if (!empty($student->$phoneField)) {
                    NotificationService::sendSms($student->$phoneField, $this->notificationData['body']);
                }
            }
        }
    }
}

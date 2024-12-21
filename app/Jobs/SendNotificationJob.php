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
        Log::info("Sending notification to student");
        foreach ($this->chunk as $student) {
            try {
                if ($this->emailEnabled && !empty($student['parent_mail'])) {
                    Mail::to($student['parent_mail'])
                        ->send(new SendPdfMail($this->notificationData));
                }

                if ($this->smsEnabled && !empty($student['parent_number'])) {
                    NotificationService::sendSms($student['parent_number'], $this->notificationData['body']);
                }
            } catch (\Exception $e) {
                Log::error("Failed to process notification for student ID: {$student['id']}, Error: {$e->getMessage()}");

                $this->fail($e);
            }
        }
    }
}

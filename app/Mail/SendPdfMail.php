<?php

namespace App\Mail;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendPdfMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $student;
    /**
     * Create a new message instance.
     */
    public function __construct($data, $student)
    {
        $this->data = $data;
        $this->student = $student;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->data['subject'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.email-template',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        if (!(isset($this->data['attach_invoice']) && $this->data['attach_invoice'])){
            return [];
        }
        if (now()->month >= 7){
            $pdf = Pdf::loadView('pdf.current_year_invoice', ['data' => $this->data, 'student' => $this->student]);
        } else {
            $pdf = Pdf::loadView('pdf.next_year_invoice', ['data' => $this->data, 'student' => $this->student]);
        }

        return [
            Attachment::fromData(fn () => $pdf->output(), 'invoice.pdf')
                ->withMime('application/pdf'),
        ];
    }
}

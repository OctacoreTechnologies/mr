<?php

namespace App\Mail;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QuotationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $customerId;

    public $customerName;

    public $subject;
    public $messageText;
    public $pdfPath;

    public $customerEmail;

    public $ccEmails;

    /**
     * Create a new message instance.
     */
    public function __construct($customerId,$customerName,$subject, $messageText, $pdfPath, $customerEmail,$ccEmails)
    {
        $this->customerId = $customerId;
        $this->customerName = $customerName;
        $this->messageText = $messageText;
        $this->pdfPath = $pdfPath;
        $this->customerEmail = $customerEmail;
        $this->subject = $subject;
        $this->ccEmails = $ccEmails;

    }

    /**
     * Define email metadata.
     */
    public function envelope(): Envelope
    {
    //    $emails = collect([$this->ccEmails,
    //     env('ADMIN_MAIL')
    //    ])->filter()->unique();
          $this->ccEmails[] =  env('ADMIN_MAIL');

        return new Envelope(
            subject: 'Quotation from Company',
            // cc: $emails->toArray(),
            cc: $this->ccEmails,
            to: $this->customerEmail 
        );
    }

    /**
     * Define the view and its data.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mails.quotation', 
            with: [
                'customerName' => $this->customerName,
                'messageText' => $this->messageText,
            ]
        );
    }

    /**
     * Attach the PDF.
     */
    public function attachments(): array
    {
         $attachments = [];

          if ( $this->pdfPath && file_exists($this->pdfPath)) {
              // Check if pdfPath is valid and the file exists
              $attachments[] = Attachment::fromPath($this->pdfPath)
                  ->as('quotation.pdf')
                  ->withMime('application/pdf');
          }

          return $attachments;
    }
}

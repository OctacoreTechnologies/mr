<?php

namespace App\Jobs;

use App\Mail\QuotationMail;
use App\Models\Quotation;
use App\Models\TearmCondition;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use NumberToWords\NumberToWords;

class SendQuotationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $customerName;
    protected $customerEmail;
    protected $messageText;
    // protected $quotation_id;
    
    protected $pdfPath;

    protected $customerId;

    protected $subject;

    protected $ccEmails;

    public function __construct($customerId,$customerName, $customerEmail, $subject ,$messageText, $pdfPath, $ccEmails)
    {
        $this->customerId=$customerId;
        $this->customerName = $customerName;
        $this->customerEmail = $customerEmail;
        $this->subject = $subject;
        $this->messageText = $messageText;
        $this->pdfPath = $pdfPath;
        $this->ccEmails = $ccEmails;

    }

    public function handle(): void
    {
       

        // Send email
        // Mail::to($this->customerEmail)->send(
        //     new QuotationMail($this->customerName, $this->messageText, $this->pdfPath)
        // );

        if (!is_null($this->customerEmail) && !empty($this->customerEmail) && filter_var($this->customerEmail, FILTER_VALIDATE_EMAIL)) {
            Mail::to($this->customerEmail)->send(new QuotationMail($this->customerId,$this->customerName,$this->subject, $this->messageText, $this->pdfPath,$this->customerEmail,$this->ccEmails)
           );
        } else {
            Log::warning('Invalid email in SendQuotationJob', [
                'email' => $this->customerEmail,
            ]);
        }


        // Optional: delete PDF after send
        if (isset($this->pdfPath) && !is_null($this->pdfPath) && file_exists($this->pdfPath)) {
            unlink($this->pdfPath);
        }
    }
}

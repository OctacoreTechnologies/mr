<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DynamicTemplateMail extends Mailable
{
  use Queueable, SerializesModels;

    public $subjectLine;
    public $htmlBody;
    public $plainBody;

    public function __construct($subjectLine, $htmlBody, $plainBody = null)
    {
        $this->subjectLine = $subjectLine;
        $this->htmlBody = $htmlBody;
        $this->plainBody = $plainBody;
    }

    public function build()
    {
        $m = $this->subject($this->subjectLine);
        if ($this->plainBody) {
            // prefer sending both html and plain
            return $m->view('emails.dynamic_plain_html', [
                'html' => $this->htmlBody,
                'plain' => $this->plainBody,
            ]);
        }
        // simple html-only
        return $m->html($this->htmlBody);
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CRMEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subjectLine;
    public $bodyContent;
    public $placeholders;

    /**
     * Create a new message instance.
     */
    public function __construct($subjectLine, $bodyContent, $placeholders = [])
    {
        $this->subjectLine = $subjectLine;
        $this->bodyContent = $bodyContent;
        $this->placeholders = is_array($placeholders)
        ? $placeholders
        : json_decode(json_encode($placeholders), true);
    }

    /**
     * Get the message envelope.
     */
      
    public function envelope(): Envelope
       {
           return new Envelope(
               subject: $this->subjectLine
           );
       }
      
    public function content(): Content
    {
        // return $this->replacePlaceholders($this->bodyContent, $this->placeholders);
        // return new Content(
        //     markdown: 'emails.crm_email', // ye markdown file
        //     with: [
        //         'bodyContent' => $this->replacePlaceholders($this->bodyContent, $this->placeholders)
        //     ]
        // );
         return new Content(
            view: 'emails.crm_email',
            with: [
                // 👇 Abhi body render hone ke time replace hoga
                'subjectLine' => $this->subjectLine,
                'bodyContent' => $this->getProcessedBody()
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }

    private function replacePlaceholders($body, $placeholders)
    {
        foreach($placeholders as $key=>$value){
            $body = str_replace('{{'.$key.'}}', $value, $body);
        }
        return $body;
    }
    private function getProcessedBody()
    {
        $body = $this->bodyContent;
        foreach ($this->placeholders as $key => $value) {
            $body = str_replace('{{' . $key . '}}', e($value), $body);
        }
        return $body;
    }

}

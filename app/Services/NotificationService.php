<?php
namespace App\Services;


class NotificationService
{
    public function send($notification)
    {
        try {

            switch ($notification->channel) {

                case 'email':
                    $this->sendEmail($notification);
                    break;

                case 'whatsapp':
                    $this->sendWhatsApp($notification);
                    break;

                default:
                    // system only (no action)
            }

            $notification->update([
                'status' => 'sent',
                'sent_at' => now()
            ]);

            $this->log($notification, 'success', 'Sent successfully');

        } catch (\Exception $e) {

            $notification->update(['status' => 'failed']);

            $this->log($notification, 'failed', $e->getMessage());
        }
    }

    private function sendEmail($notification)
    {
        $email = $notification->meta['email'] ?? null;

        // if ($email) {
        //     Mail::to($email)->send(new ReminderMail($notification));
        // }
    }

    private function sendWhatsApp($notification)
    {
        $phone = $notification->meta['phone'] ?? null;

        if ($phone) {
            // future integration (Twilio / Meta API)
        }
    }

    private function log($notification, $status, $response)
    {
        $notification->logs()->create([
            'channel' => $notification->channel,
            'status' => $status,
            'response' => $response
        ]);
    }
}
?>
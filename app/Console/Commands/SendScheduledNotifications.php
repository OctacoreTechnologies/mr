<?php

namespace App\Console\Commands;

use App\Models\Reminder;
use App\Models\Quotation;
use App\Models\Customer;
use App\Models\User;
use App\Mail\CustomerNotificationMail;
use App\Mail\AdminNotificationMail;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

use function PHPUnit\Framework\isEmpty;

class SendScheduledNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:send-scheduled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send scheduled notifications to Admin and Customer based on sent_date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the current date and time in the correct format
        // $now = Carbon::now()->format('Y-m-d H:i:00'); 
         $now = Carbon::now(); 
        // Fetch notifications where sent_date matches current time
        // $notifications = Reminder::where('sent_date', $now)->get();
          $notifications = Reminder::whereDate('sent_date', $now->toDateString())
        ->where('sent_date', '>=', $now)
        ->orderByDesc('created_at')
        ->get();

        foreach ($notifications as $notification) {
            $customer=null;
            if($notification->model == "Quotation"){
             $quotation = Quotation::with('customer')->find($notification->type_id);
             $customer=Customer::find($quotation->customer_id);
            }
            elseif($notification->model== "Customer"){
             $customer=Customer::find($notification->type_id);
            }
    
            // $customer = $quotation ? Customer::find($quotation->customer_id) : null;

            if (!is_null($customer)) {
                $this->sendCustomerNotification($customer, $notification);
            }

        
            $this->sendAdminNotification($notification);
            
        }

        $this->info('Scheduled notifications sent successfully!');
        return 0;
    }

    /**
     * Get the customer email and send notification.
     *
     * @param  \App\Models\Customer  $customer
     * @param  \App\Models\Reminder  $notification
     * @return void
     */
    protected function sendCustomerNotification(Customer $customer, $notification)
    {
        // Send email to customer

       if (!empty($customer->contact_person_1_email)) {
        Mail::to($customer->contact_person_1_email)->send(new CustomerNotificationMail($notification));
        $this->info('Notification sent to customer: ' . $customer->contact_person_1_email);
       } else {
        $this->warn('Customer email is missing. Notification not sent.');
       }
      
    }

    /**
     * Send notification to admin users.
     *
     * @param  \App\Models\Reminder  $notification
     * @return void
     */
    protected function sendAdminNotification($notification)
    {
        $admins = User::get();

        foreach ($admins as $admin) {
           
            Mail::to($admin->email)->send(new AdminNotificationMail($notification));
            $this->info('Notification sent to admin: ' . $admin->email);
        }
    }
}

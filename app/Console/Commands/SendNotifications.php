<?php

namespace App\Console\Commands;

use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Console\Command;

class SendNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This comman is run auto on server and send then send notification';

    /**
     * Execute the console command.
     */
      public function handle(){
        $notifications = Notification::where('status', 'pending')
            ->where('send_at', '<=', now())
            ->get();

        foreach ($notifications as $notification) {
            app(NotificationService::class)->send($notification);
        }
    }
}

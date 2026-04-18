<?php

namespace App\Http\Controllers\notifications;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function countQuotationReminder()
    {
        $now = Carbon::now('Asia/Kolkata');

        $totalNotifications = Notification::where('notifiable_type', Customer::class)
            ->where('send_at', '<=', $now)
            ->where('status', 'pending')
            ->count();

        Log::info('Total Pending Notifications:', ['count' => $totalNotifications]);

        $dropdownHtml = '';
        $notifications = [];

        if ($totalNotifications > 0) {
            $notifications[] = [
                'icon' => 'fas fa-fw fa-bell text-primary',
                'text' => $totalNotifications . ' Reminder(s)',
                'href' => route('notification.index'),
            ];
        }

        foreach ($notifications as $key => $not) {
            $icon = "<i class='mr-2 {$not['icon']}'></i>";
            $dropdownHtml .= "<a href='{$not['href']}' class='dropdown-item'>
                                {$icon}{$not['text']}
                              </a>";

            if ($key < count($notifications) - 1) {
                $dropdownHtml .= "<div class='dropdown-divider'></div>";
            }
        }

        return [
            'label'       => $totalNotifications,
            'label_color' => 'danger',
            'icon_color'  => 'dark',
            'dropdown'    => $dropdownHtml,
        ];
    }

    /**
     * Today's / due notifications list page
     */
    public function index()
    {
        $notifications = Notification::with('notifiable')
            ->where('notifiable_type', Customer::class)
            ->where('send_at', '<=', now('Asia/Kolkata'))
            ->where('status', 'pending')
            ->orderByDesc('send_at')
            ->get();

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Dismiss / delete notification
     */
    public function destroy(string $id)
    {
        Notification::findOrFail($id)->delete();

        return redirect()
            ->route('notification.index')
            ->with('success', 'Notification dismissed.');
    }
}
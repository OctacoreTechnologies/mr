<?php

namespace App\Http\Controllers\notifications;

use App\Http\Controllers\Controller;
use App\Http\Controllers\remiders\ReminderController;
use App\Models\Quotation;
use App\Models\QuotationNotification;
use App\Models\Reminder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
public function countQuotationReminder()
{
    $now = Carbon::now();

    // $totalQuotationNotification = QuotationNotification::with('quotation')
    //     ->whereDate('reminder_datetime', $now->toDateString())
    //     ->where('reminder_datetime', '<=', $now)
    //     ->whereNull('read_at')
    //     ->orderByDesc('created_at')
    //     ->count();
    $now = Carbon::now('Asia/Kolkata'); // Current date and time

      $totalQuotationNotification =  Reminder::whereDate('sent_date', $now->toDateString())
        ->whereTime('sent_date', '<=', $now->toTimeString()) // Ensure time is less than or equal to now
        ->orderByDesc('created_at')
        ->count();


    Log::info('Total Quotation Reminders:', ['count' => $totalQuotationNotification]);

    $dropdownHtml = '';
    $notifications = [];

    if ($totalQuotationNotification > 0) {
        $notifications[] = [
            'icon' => 'fas fa-fw fa-users text-primary',
            'text' => $totalQuotationNotification . ' Reminder(s)',
            'href' => route('reminder.today'),
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
        'label' => $totalQuotationNotification,
        'label_color' => 'danger',
        'icon_color' => 'dark',
        'dropdown' => $dropdownHtml,
    ];
}
}

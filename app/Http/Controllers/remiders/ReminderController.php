<?php

namespace App\Http\Controllers\remiders;

use App\Http\Controllers\Controller;
use App\Models\Quotation;
use App\Models\QuotationNotification;
use App\Models\Reminder;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    public function remiderToday(Request $request){
        $now = Carbon::now();

   //  $quotations = QuotationNotification::with('quotation')
   //      ->whereDate('reminder_datetime', $now->toDateString())  // same date
   //      ->where('reminder_datetime', '<=', $now)                // time should be <= now
   //      ->whereNull('read_at')                                  // unread only
   //      ->orderByDesc('created_at')
   //      ->get();
     $now = Carbon::now('Asia/Kolkata'); // Current date and time

      $reminders = Reminder::whereDate('sent_date', $now->toDateString())
        ->whereTime('sent_date', '<=', $now->toTimeString()) // Ensure time is less than or equal to now
        ->orderByDesc('created_at')
        ->get();

       return response()->view('reminders.index', [
        'reminders' => $reminders
       ]);

    }

    

    public function readAt($id){
         $quotationNotification=QuotationNotification::find($id);
         if(!empty($quotationNotification)){
            $quotationNotification->update(['read_at'=>now()]);
            return redirect()->back();
         }

         return response()->json([
            'status'=>false,
            'message'=>'not done',
         ]);
     }

     public function reminderDestroy(string $id){
        $reminder=Reminder::findOrFail($id);
        $reminder->delete();
        return response()->redirectToRoute('reminder.today')->with('success','Remidner is deleted successfully');
     }
}

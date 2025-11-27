<?php

namespace App\Http\Controllers\mail;

use App\Http\Controllers\Controller;
use App\Mail\CRMEmail;
use App\Models\Customer;
use App\Models\EmailTemplate;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController_2 extends Controller
{
    public function create(){
        $templates = EmailTemplate::all();
        return view('emails.create',compact('templates'));
    }

    public function fetchRecipients(Request $request)
    {
        $type = $request->type;

        $data = collect();

        if ($type === 'lead') {
            $data = Lead::select('id','full_name','email')->get();
        } elseif ($type === 'customer') {
            $data = Customer::select(
                'id','company_name','email',
                'contact_person_1_email',
                'contact_person_2_email',
                'contact_person_3_email',
                'contact_person_4_email',
                'contact_person_5_email',
                'contact_person_6_email'
            )->get();
        } elseif ($type === 'all') {
            // For multi-select all combined
            $leads = Lead::select('id','name','email')->get();
            $customers = Customer::select(
                'id','name','email',
                'contact_person_1_email',
                'contact_person_2_email',
                'contact_person_3_email',
                'contact_person_4_email',
                'contact_person_5_email',
                'contact_person_6_email'
            )->get();
            $data = $leads->merge($customers);
        }

        return response()->json($data);
    }

    public function getTemplate($id)
    {
        $template = EmailTemplate::findOrFail($id);
        return response()->json($template);
    }

   public function send(Request $request)
    {
        $request->validate([
            'subject'=>'required',
            'body'=>'required',
            'placeholder'=>'nullable',
        ]);
        $placeholders = $request->placeholders ?? [];
        

        // return $request->all();

        // $adminEmails = User::where('is_admin',1)->pluck('email')->toArray();
        $adminEmails =[];
        $toEmails = $request->recipients ?? [];
        $ccEmails = $request->cc ?? $adminEmails;
        $ccEmails = array_merge($ccEmails, $adminEmails); // always include admin
        // return $toEmails;
        foreach($toEmails as $email){
            // Mail::send([],[],function($message) use ($email,$ccEmails,$request){
            //     $message->to($email)
            //             ->cc($ccEmails)
            //             ->subject($request->subject)
            //             ->setBody($request->body,'text/html');
            // });
            // Mail::to($email)->cc($ccEmails)->send(new CRMEmail($request->subject,$request->body,$placeholders));
            Mail::to($email)
                         ->cc($ccEmails)
                         ->queue(new CRMEmail($request->subject, $request->body,  json_decode(json_encode($placeholders), true)));
        }

        return back()->with('success','Emails sent successfully!');
   }
}

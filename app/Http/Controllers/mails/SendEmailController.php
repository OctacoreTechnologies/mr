<?php

namespace App\Http\Controllers\mails;

use App\Http\Controllers\Controller;
use App\Jobs\SendQuotationJob;
use App\Mail\QuotationMail;
use App\Models\Quotation;
use App\Models\TearmCondition; 
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use NumberToWords\NumberToWords;

class SendEmailController extends Controller
{
    public function sendMail(Request $request)
{
    

    $request->validate([
        'customer_id' => 'required',
        'customer_name' => 'required',
        'customer_email' => 'required|email',
        'subject'=>'required',
        'message' => 'required',
        'quotation_id'=>'required|exists:quotations,id',
        'withPdf'=>'nullable',
        'contact_person_2_email' => 'nullable|email',
        'contact_person_3_email' => 'nullable|email',
        'contact_person_4_email' => 'nullable|email',
        'contact_person_5_email' => 'nullable|email',
        'contact_person_6_email' => 'nullable|email',
    ]);


    // store email in array
     $ccEmails = [];

    // Step 3: Loop through the possible email fields
    $emailFields = [
        'contact_person_2_email',
        'contact_person_3_email',
        'contact_person_4_email',
        'contact_person_5_email',
        'contact_person_6_email'
    ];

    foreach ($emailFields as $emailField) {
        // Check if the email is not null and is valid
        if ($request->has($emailField) && filter_var($request->$emailField, FILTER_VALIDATE_EMAIL)) {
            $ccEmails[] = $request->$emailField; // Add valid email to the array
        }
    }
    //end storing email in array

   

    $isPdf=false;
    

    if(isset($request->withPdf) && $request->withPdf){
        $isPdf=true;
    }
    // return $isPdf;
    $customerId=$request->customer_id;
    $customerName = $request->customer_name;
    $customerEmail = $request->customer_email;
    $messageText = $request->message;
    $subject = $request->subject;
    $pdfPath=null;

    // Load the quotation data (assuming ID passed or use logic)
    if($isPdf){
        $numberWords = new NumberToWords();
        $numberTransformer = $numberWords->getNumberTransformer('en');
        $termCondition = TearmCondition::findOrFail(1);
        $quotation = Quotation::with(['customer', 'application', 'user', 'machine', 'modele', 'materialToProcess', 'batch', 'mixingTool', 'electricalControl', 'acFrequencyDrive', 'bearinge', 'pneumatic', 'batche2'])->findOrFail($request->quotation_id);
        $words = convertToIndianWords((int) ($quotation->total_price ?? 0) - (int) ($quotation->discount ?? 0));
        $viewName = null;
        if ($quotation->machine_id == 18) {
            $viewName = "quotations.new_pdf";
        } else if ($quotation->machine_id == 28) {
            $viewName = "quotations.pdfs.vertical_cooler_mixture";
        } else if ($quotation->machine_id == 22) {
            $viewName = "quotations.pdfs.grinder";
        } else if ($quotation->machine_id == 29) {
            $viewName = "quotations.pdfs.high_speed_heater_and_vertical_cooler_mixture";
        } else if ($quotation->machine_id == 30) {
            $viewName = "quotations.pdfs.high_speed_heater_and_horizontal_cooler";
        } else {
            $viewName = "quotations.new_pdf";
        }

    if (!$quotation) {
        return redirect()->back()->with('error', 'Quotation not found.');
    }

    // Generate PDF on the fly
        $pdf = PDF::loadView($viewName, [
            "quotation" => $quotation,
            'termCondition' => $termCondition,
            'words' => $words,
        ])->setOption([
                    'fontDir' => public_path('/fonts'),
                    'fontCache' => public_path('/fonts'),
                    'defaultFont' => 'Poppins'
        ]);
        $directory = storage_path('app/public/quotations');
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true); // Create with permissions
        }
        
        $pdfPath = $directory . "/quotation_{$quotation->id}.pdf";
        $pdf->save($pdfPath); // Save to storage
}
    // Send Email
    // Mail::to($customerEmail)->send(new QuotationMail($customerName, $messageText, $pdfPath));
    Log::info('SendQuotationJob dispatching', [
    'customer_id'=>$customerId,
    'customer_name' => $customerName,
    'customer_email' => $customerEmail,
    'subject'=>$subject,
    'message' => $messageText,
    'pdfPath' => $pdfPath,
    'ccEmails' => $ccEmails,
    ]);
     SendQuotationJob::dispatch(
        $customerId,
        $customerName,
        $customerEmail,
        $subject,
        $messageText,
        $pdfPath,
        $ccEmails,
      );

    return redirect()->back()->with('success', 'Email sent with quotation PDF attached.');
  }
}

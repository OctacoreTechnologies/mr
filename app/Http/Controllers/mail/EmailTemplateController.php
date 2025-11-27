<?php

namespace App\Http\Controllers\mail;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmailTemplateRequest;
use App\Mail\DynamicTemplateMail;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EmailTemplateController extends Controller
{
     public function index()
    {
        $templates = EmailTemplate::orderBy('name')->paginate(20);
        return view('email_templates.index', compact('templates'));
    }

    public function create()
    {
        return view('email_templates.create');
    }

    public function store(StoreEmailTemplateRequest $req)
    {
        // sanitize HTML before saving (recommended)
        // composer require mews/purifier
        // $cleanBody = \Purifier::clean($req->body);
        $data = $req->validated();
        $data['slug'] = Str::slug($data['name']);
        $data['created_by'] = Auth::user()->id;
        $tpl = EmailTemplate::create($data);
        // extract placeholders and save as variables
        $tpl->variables = $tpl->extractPlaceholders();
        $tpl->save();
        return redirect()->route('email-templates.index')->with('success', 'Template created.');
    }

    public function edit(EmailTemplate $emailTemplate)
    {
        return view('email_templates.edit', ['template' => $emailTemplate]);
    }

    public function update(StoreEmailTemplateRequest $req, EmailTemplate $emailTemplate)
    {
        $data = $req->validated();
        $data['updated_by'] = Auth::user()->id;
        $emailTemplate->update($data);
        $emailTemplate->variables = $emailTemplate->extractPlaceholders();
        $emailTemplate->save();
        return back()->with('success','Updated');
    }

    public function destroy(EmailTemplate $emailTemplate)
    {
        $emailTemplate->delete();
        return back()->with('success','Deleted');
    }

    // preview (render with provided sample data)
    public function preview(Request $request, EmailTemplate $emailTemplate)
    {
        // $request->input('sample', []);
        $sampleData = $request->input('sample', []);
        $rendered = $emailTemplate->render($sampleData);
        // return HTML fragment for modal
        return response()->json(['html' => $rendered]);
    }

    // send test email
    public function sendTest(Request $request, EmailTemplate $emailTemplate)
    {
        $request->validate([
            'to' => 'required|email',
        ]);
        $to = $request->to;
        // prepare sample data: use variables -> empty or sample values
        $vars = $emailTemplate->extractPlaceholders();
        $sample = [];
        foreach ($vars as $v) $sample[$v] = "[{$v}_sample]";
        $html = $emailTemplate->render($sample);

        Mail::to($to)->send(new DynamicTemplateMail($emailTemplate->subject, $html, $emailTemplate->plain_body));
        return back()->with('success', 'Test email sent to '.$to);
    }
}

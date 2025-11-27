<?php

namespace App\Http\Controllers\mail;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailTemplateController_2 extends Controller
{
        public function index() {
        $templates = EmailTemplate::all();
    //    return $templates;
        return view('email_templates.index', compact('templates'));
    }

    public function create() {
        return view('email_templates.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string',
            'body' => 'required|string',
        ]);

        EmailTemplate::create([
            'name' => $request->name,
            'subject' => $request->subject,
            'body' => $request->body,
            'variables' => $request->variables ?? [],
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('email-templates.index')->with('success', 'Template created!');
    }

    public function edit(EmailTemplate $emailTemplate) {
        return view('email_templates.edit', compact('emailTemplate'));
    }

    public function update(Request $request, EmailTemplate $emailTemplate) {
        $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string',
            'body' => 'required|string',
        ]);

        $emailTemplate->update([
            'name' => $request->name,
            'subject' => $request->subject,
            'body' => $request->body,
            'variables' => $request->variables ?? [],
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('email-templates.index')->with('success', 'Template updated!');
    }

    public function destroy(EmailTemplate $emailTemplate) {
        $emailTemplate->delete();
        return back()->with('success', 'Template deleted!');
    }

  public function show($id)
{
    // Fetch the email template by ID
    $emailTemplate = EmailTemplate::findOrFail($id);

    // Return the show view with the template
    return view('email_templates.show', compact('emailTemplate'));
}
}

<?php

namespace App\Http\Controllers\mail;

use App\Http\Controllers\Controller;
use App\Http\Requests\MailStoreUpdateRequest;
use App\Models\Application;
use App\Models\Email;
use App\Models\Machine;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mails = Email::with(['machine','application'])->orderByDesc('created_at')->get();
        return response()->view('mails.index',[
            'mails'=>$mails
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $machines = Machine::orderByDesc('created_at')->get();
        // return $applications;

        return response()->view('mails.create',[
            'machines' => $machines,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MailStoreUpdateRequest $request)
    {
        Email::create($request->validated());
        session()->flash('success','Email is added successfully');
        return response()->redirectToRoute('mail.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $mail =  Email::findOrFail($id);
        return response()->view('mails.edit',[
            'machines' => Machine::orderByDesc('created_at')->get(),
            'mail' =>$mail,
            'applications' => Application::select('id','name','machine_id')->where('machine_id',$mail->machine_id)->orderByDesc('created_at')->get(),
    
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MailStoreUpdateRequest $request, string $id)
    {
        Email::findOrFail($id)->update($request->validated());
        session()->flash('success','Email is updated successfully');
        return response()->redirectToRoute('mail.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Email::findOrFail($id)->delete();
        session()->flash('success','Email is deleted successfully');
        return response()->redirectToRoute('mail.index');
    }

    public function applicatonEmail(string $applicationId){
        $email = Email::where('application_id',$applicationId)->first();
        return response()->json([
            'email' => $email,
        ]);
    }
}

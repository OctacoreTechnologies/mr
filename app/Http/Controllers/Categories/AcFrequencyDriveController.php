<?php

namespace App\Http\Controllers\categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAcFrequencyDriveRequest;
use App\Models\AcFequencyDrive;
use Illuminate\Http\Request;

class AcFrequencyDriveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $acFrequencyDrives=AcFequencyDrive::orderByDesc('created_at')->get();
        return view('categories.ac_frequency_drive.index',compact('acFrequencyDrives'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAcFrequencyDriveRequest $request)
    {
        $validated=$request->validated();
        AcFequencyDrive::create($validated);
        return response()->redirectToRoute('ac-frequency-drive.index');
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
        $acFrequencyDrive=AcFequencyDrive::findOrFail($id);
        return response()->view('categories.ac_frequency_drive.update',compact('acFrequencyDrive'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAcFrequencyDriveRequest $request, string $id)
    {
        $validated=$request->validated();
        AcFequencyDrive::findOrFail($id)->update($validated);
        session()->flash('success','Ac Frequency Drive Updated Successfully');
        return response()->redirectToRoute('ac-frequency-drive.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        AcFequencyDrive::findOrFail($id)->delete();
        session()->flash('success','Ac Frequency Drive Updated Successfully');
        return response()->redirectToRoute('ac-frequency-drive.index');
    }
}

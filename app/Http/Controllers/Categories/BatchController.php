<?php

namespace App\Http\Controllers\categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBatchRequest;
use App\Models\Batch;
use App\Models\Machine;
use App\Models\Modele;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $batches=Batch::with(['machine','modele'])->orderByDesc('created_at')->get();
        $machines=Machine::orderByDesc('created_at')->get();
        
        return response()->view('categories.batches.index',compact('batches','machines'));
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
    public function store(StoreBatchRequest $request)
    {
        $validated=$request->validated();
        Batch::create($validated);
        session()->flash('success','Batches is added successfully');
        return response()->redirectToRoute('batch.index');
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
        $batch=Batch::findOrFail($id);
        return response()->view('categories.batches.update',compact('batch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreBatchRequest $request, string $id)
    {
        $validated=$request->validated();
        $batch=Batch::findOrFail($id);
        $batch->update($validated);
        return response()->redirectToRoute('batch.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $batch=Batch::findOrFail($id);
        $batch->delete();
        session()->flash('danger','Batche Deleted Successfully');
        return response()->redirectToRoute('batch.index');
    }
}

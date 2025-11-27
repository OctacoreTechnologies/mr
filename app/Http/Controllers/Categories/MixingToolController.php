<?php

namespace App\Http\Controllers\categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMixingToolRequest;
use App\Models\MixingTool;
use Illuminate\Http\Request;

class MixingToolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mixingTools=MixingTool::orderByDesc('created_at')->get();
        return view('categories.mixing_tool.index',compact('mixingTools'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMixingToolRequest $request)
    {
        $validated=$request->validated();
        MixingTool::create($validated);
        return response()->redirectToRoute('mixing-tool.index');
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
        $mixingTool=MixingTool::findOrFail($id);
        return response()->view('categories.mixing_tool.update',compact('mixingTool'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreMixingToolRequest $request, string $id)
    {
           $validated=$request->validated();
           $mixingTool=MixingTool::findOrFail($id);
           $mixingTool->update($validated);
           session()->flash('success','Mixing Tool Updated Successfully');
           return response()->redirectToRoute('mixing-tool.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
           $mixingTool=MixingTool::findOrFail($id);
           $mixingTool->delete();
           session()->flash('danger','Mixing Tool Deleted  Successfully');
           return response()->redirectToRoute('mixing-tool.index');
    }
}

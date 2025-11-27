<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBearingRequest;
use App\Http\Requests\StorePneumaticRequest;
use App\Models\Pneumatic;
use Illuminate\Http\Request;

class PneumaticController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pneumatics=Pneumatic::orderByDesc('created_at')->get();
        return view('categories.pneumatics.index',compact('pneumatics'));
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
    public function store(StorePneumaticRequest $request)
    {
        Pneumatic::create($request->validated());
        session()->flash('success','Pneumatic is created successfully');
        return response()->redirectToRoute('pneumatic.index');
    
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
        $pneumatic=Pneumatic::find($id);
        return response()->view('categories.pneumatics.update',compact('pneumatic'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePneumaticRequest $request, string $id)
    {
       Pneumatic::find($id)->update($request->validated());
       session()->flash('success','Pneumatic is update Successfully');
       return response()->redirectToRoute('pneumatic.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Pneumatic::find($id)->delete();
        session()->flash('success','Pneumatic is deleted Successfully');
        return response()->redirectToRoute('pneumatic.index');
    }
}

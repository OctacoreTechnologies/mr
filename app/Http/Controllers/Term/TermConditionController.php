<?php

namespace App\Http\Controllers\Term;

use App\Http\Controllers\Controller;
use App\Http\Requests\TermConditionRequest;
use App\Models\TearmCondition;
use Illuminate\Http\Request;

class TermConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $termAndConditions=TearmCondition::all();
        return response()->view('terms.index',[
            'termAndCondtions'=>$termAndConditions
        ]);
        // return response()->redirectToRoute('term-conditions.edit',1);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->view('terms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TermConditionRequest $request)
    {
        TearmCondition::create($request->validated());
        return response()->redirectToRoute('term-conditions.index');
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
           $termCondition=TearmCondition::findOrFail($id);
           return response()->view('terms.edit',[
             'termCondition'=>$termCondition
           ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TermConditionRequest $request, string $id)
    {
        $condition=TearmCondition::findOrFail($id);
        $condition->update($request->validated());
        return response()->redirectToRoute('term-conditions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $condition=TearmCondition::findOrFail($id);
        $condition->delete();
        return response()->redirectToRoute('terms.index');
    }
}

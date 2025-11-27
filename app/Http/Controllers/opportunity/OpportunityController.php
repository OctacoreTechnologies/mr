<?php

namespace App\Http\Controllers\opportunity;

use App\Http\Controllers\Controller;
use App\Http\Requests\OpportunityRequest;
use App\Models\Lead;
use App\Models\Opportunity;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;

class OpportunityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $opportunities = Opportunity::with('quotation')->orderByDesc('created_at')->get();
        return response()->view('opportunities.index', [
            'opportunities' => $opportunities
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $leads = Lead::orderByDesc('created_at')->where('status', 'qualified')->get();
        $users = User::orderByDesc('created_at')->get();
        $customers = Customer::orderByDesc('created_at')->get();



        return response()->view('opportunities.create', [
            'leads' => $leads,
            'users' => $users,
            'customers' => $customers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OpportunityRequest $request)
    {
        $opportunity = Opportunity::create($request->validated());
        // session()->flash('success','opportunity is created successfully');
        session()->flash('success', 'opportunity is created successfully');
        return response()->redirectTo(route('opportunity.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $opportunity = Opportunity::with(['lead'])->findOrFail($id);

        return response()->view('opportunities.show', [
            'opportunity' => $opportunity,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $opportunity = Opportunity::findOrFail($id);
        $leads = Lead::orderByDesc('created_at')->get();
        return response()->view('opportunities.edit', [
            'opportunity' => $opportunity,
            'leads' => $leads
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OpportunityRequest $request, string $id)
    {
        $opportunity = Opportunity::findOrFail($id);
        $opportunity->update($request->validated());
        session()->flash('success', 'opportunity updated successfully');
        return response()->redirectToRoute('opportunity.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $opportunity = Opportunity::findOrFail($id);
        $opportunity->delete();
        session()->flash('success', 'opportunity is deleted successfully');
        return response()->redirectToRoute('opportunity.index');
    }
}

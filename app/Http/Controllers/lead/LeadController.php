<?php

namespace App\Http\Controllers\lead;

use App\Http\Controllers\Controller;
use App\Http\Requests\LeadRequest;
use App\Http\Requests\UpdateLeadRequest;
use App\Models\Lead;
use App\Models\State;
use App\Models\User;
use App\Models\Country;
use App\Models\Customer;
use App\Models\Region;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $currentYear = now()->year;

        // Calculate the start and end of the financial year
        // Financial Year runs from April to March
        $startDate = now()->month >= 4 ? Carbon::create($currentYear, 4, 1) : Carbon::create($currentYear - 1, 4, 1);
        $endDate = $startDate->copy()->addYear()->subDay();
        $leads = Customer::whereBetween('created_at', [$startDate, $endDate])
            ->where('type', 'lead')->orderByDesc('created_at')->get();

        return response()->view('leads.index', [
            "leads" => $leads,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $states = State::orderBy('name')->get();
        $users = User::orderByDesc('created_at')->get();
        return response()->view('leads.create', [
            'states' => $states,
            'users' => $users,
            'countries' => Country::all(),
            'regions' => Region::orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LeadRequest $leadRequest)
    {
        $lead = Lead::create($leadRequest->validated());
        session()->flash('success', 'lead is created successfully');
        return redirect()->route('lead.index')->with('success', 'Lead created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $lead = Lead::with('leadFollowedBy')->findOrFail($id);
        // return $lead;

        return response()->view('leads.show', compact('lead'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $lead = Customer::findOrFail($id);
        $states = State::orderBy('name')->get();
        $users = User::orderByDesc('created_at')->get();
        return response()->view('leads.edit', [
            'lead' => $lead,
            'states' => $states,
            'users' => $users,
            'countries' => Country::all(),
            'regions' => Region::orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLeadRequest $updateLeadRequest, string $id)
    {
        $lead = Lead::findOrFail($id);
        $lead->update($updateLeadRequest->validated());
        session()->flash('success', 'lead is successfully updated');
        return response()->redirectTo(route('lead.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lead = Lead::findOrFail($id);
        $lead->delete();
        session()->flash('success', 'lead is deleted successfull');
        return response()->redirectTo(route('lead.index'));
    }
}

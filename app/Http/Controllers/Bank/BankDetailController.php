<?php

namespace App\Http\Controllers\Bank;

use App\Http\Controllers\Controller;
use App\Models\BankDetail;
use Illuminate\Http\Request;

class BankDetailController extends Controller
{
    public function index(){
        $bankDetail = BankDetail::findOrFail(1);
        return view('bank.bank-detail', compact('bankDetail'));
    }

    public function update(Request $request){
        $bankDetail = BankDetail::findOrFail(1);
        $bankDetail->update($request->all());
        return redirect()->back()->with('success', 'Bank details updated successfully.');
    }
}

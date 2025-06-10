<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PropertyCheckoutTransaction;
use App\Models\PropertyVisit;
use App\Models\User;
use App\Models\Property;

class AdminController extends Controller
{
    /**
     * Display a listing of the transactions.
     */
    public function index()
    {
        $transactions = PropertyCheckoutTransaction::all();
        return view('admin.transactions', compact('transactions'));
    }

    /**
     * Update the status of a transaction.
     */
    public function updateStatus(Request $request, PropertyCheckoutTransaction $transaction)
    {
        $request->validate([
            'status_transaksi' => 'required|in:verified,rejected,pending',
        ]);

        $transaction->status_transaksi = $request->status_transaksi;
        $transaction->save();

        return redirect()->back()->with('success', 'Transaction status updated successfully.');
    }

    /**
     * Display a listing of the property visits.
     */
    public function propertyVisits()
    {
        $propertyVisits = PropertyVisit::with(['user', 'property'])->get();
        return view('admin.property_visits', compact('propertyVisits'));
    }

    /**
     * Update the status of a property visit.
     */
    public function updatePropertyVisitStatus(Request $request, PropertyVisit $propertyVisit)
    {
        $request->validate([
            'status' => 'required|in:pending,contacted,visited,cancelled',
        ]);

        $propertyVisit->status = $request->status;
        $propertyVisit->save();

        return redirect()->back()->with('success', 'Property visit status updated successfully.');
    }
}

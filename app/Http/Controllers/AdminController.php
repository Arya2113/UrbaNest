<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PropertyCheckoutTransaction;
use App\Models\PropertyVisit;
use App\Models\User;
use App\Models\Property;

class AdminController extends Controller
{

    public function index()
    {
        $transactions = PropertyCheckoutTransaction::orderBy('created_at', 'desc')->get();
        return view('admin.transactions', compact('transactions'));
    }


    public function updateStatus(Request $request, PropertyCheckoutTransaction $transaction)
    {
        $request->validate([
            'status_transaksi' => 'required|in:verified,rejected,pending',
        ]);

        $transaction->status_transaksi = $request->status_transaksi;
        $transaction->save();

        return redirect()->back()->with('success', 'status berhasil diupdate');
    }


    public function propertyVisits()
    {
        $propertyVisits = PropertyVisit::with(['user', 'property'])->orderBy('created_at', 'desc')->get();
        return view('admin.property_visits', compact('propertyVisits'));
    }


    public function updatePropertyVisitStatus(Request $request, PropertyVisit $propertyVisit)
    {
        $request->validate([
            'status' => 'required|in:pending,contacted,visited,cancelled',
        ]);

        $propertyVisit->status = $request->status;
        $propertyVisit->save();

        return redirect()->back()->with('success', 'kunjungan properti berhasil diupdate');
    }

    public function destroy(PropertyCheckoutTransaction $transaction)
    {

        $transaction->delete();

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus.');
    }
}

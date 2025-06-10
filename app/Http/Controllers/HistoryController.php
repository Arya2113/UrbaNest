<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PropertyCheckoutTransaction; 
use App\Models\User;

class HistoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to view your transaction history.');
        }

        // Assuming a relationship 'transactions' exists on the User model
        // and the status column is named 'status' on the transaction model
        $transactions = $user->transactions()->with('property')->get(); // Eager load property to display property name

        $processVerificationTransactions = $transactions->where('status_transaksi', 'uploaded');
        $purchasedTransactions = $transactions->where('status_transaksi', 'verified'); // Assuming 'verified' means purchased
        return view('historytransaction', [
            'processVerificationTransactions' => $processVerificationTransactions,
            'purchasedTransactions' => $purchasedTransactions,
        ]);
    }
}

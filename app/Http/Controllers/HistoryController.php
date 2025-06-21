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

         
         
        $transactions = $user->transactions()->with('property')->get();  

        $processVerificationTransactions = $transactions->where('status_transaksi', 'uploaded');
        $purchasedTransactions = $transactions->where('status_transaksi', 'verified');  
        return view('historytransaction', [
            'processVerificationTransactions' => $processVerificationTransactions,
            'purchasedTransactions' => $purchasedTransactions,
        ]);
    }
}

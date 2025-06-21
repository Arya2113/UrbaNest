<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PropertyCheckoutTransaction; 
use App\Models\User;
use App\Models\ServiceOrder;


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
        $serviceOrders = ServiceOrder::with('architect')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('historytransaction', [
            'processVerificationTransactions' => $processVerificationTransactions,
            'purchasedTransactions' => $purchasedTransactions,
            'serviceOrders' => $serviceOrders,
        ]);
    }
}

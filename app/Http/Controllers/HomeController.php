<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\PropertyCheckoutTransaction;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProperties = Property::withCount('users')
                                    ->whereDoesntHave('propertyCheckoutTransactions', function ($query) {
                                        $query->whereIn('status_transaksi', ['uploaded', 'verified']);
                                    })
                                    ->orderByDesc('users_count')
                                    ->take(3)
                                    ->get();

        return view('welcome', compact('featuredProperties'));
    }
}

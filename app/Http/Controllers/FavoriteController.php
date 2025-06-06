<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PropertyCheckoutTransaction;

class FavoriteController extends Controller
{
    public function toggleFavorite(Property $property)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Silakan login untuk menambahkan ke favorit.'], 401);
        }

        $user = Auth::user();
        $isFavorited = $user->properties()->toggle($property->id);

        return response()->json(['isFavorited' => count($isFavorited['attached']) > 0]);
    }

    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to view your favorites.');
        }

        $favoriteProperties = $user->properties()
            ->whereDoesntHave('propertyCheckoutTransactions', function ($query) {
                $query->whereIn('status_transaksi', ['uploaded', 'verified']);
            })
            ->get();

        return view('favorite', compact('favoriteProperties'));
    }
}

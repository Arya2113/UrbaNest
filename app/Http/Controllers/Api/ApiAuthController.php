<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Property;
use App\Models\PropertyCheckoutTransaction;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class ApiAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('android-token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token'   => $token,
            'user'    => $user
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('android-token')->plainTextToken;

        return response()->json([
            'message' => 'Registration successful',
            'token' => $token,
            'user' => $user
        ]);
    }

    public function checkout(Request $req, $propertyId)
    {
        $user = $req->user();

        $property = Property::find($propertyId);
        if (!$property) {
            return response()->json(['message' => 'Properti tidak ditemukan.'], 404);
        }

        

        
        $tx = PropertyCheckoutTransaction::where('user_id', $user->id)
            ->where('property_id', $property->id)
            ->whereIn('status_transaksi', [
                'uploaded','processing','confirmed','completed','rejected'
            ])
            ->latest()
            ->first();

        if ($tx) {
            return response()->json([
                'message' => 'Transaksi sudah ada.',
                'transaction_id' => $tx->id,
                'status' => $tx->status_transaksi,
                'property' => $property

            ]);
        }

        $harga = $property->price;
        $fee   = $harga * 0.05;
        $code  = $user->id + $property->id + 100;
        $total = $harga + $fee + $code;

        return response()->json([
            'property_id' => $property->id,
            'harga_properti' => $harga,
            'biaya_layanan' => $fee,
            'kode_unik' => $code,
            'total_transfer' => $total,
            'property' => $property
        ]);
    }
        

    public function uploadProof(Request $req, $propertyId)
    {
        $user = $req->user();

        
        $property = Property::find($propertyId);
        if (!$property) {
            return response()->json(['message' => 'Properti tidak ditemukan.'], 404);
        }

        
        $req->validate([
            'proof' => 'required|file|mimes:jpeg,jpg,png,pdf|max:5120',
        ]);

        
        $exists = PropertyCheckoutTransaction::where('user_id', $user->id)
            ->where('property_id', $property->id)
            ->whereIn('status_transaksi', ['uploaded', 'rejected'])
            ->first();

        if ($exists) {
            return response()->json(['message' => 'Transaksi sudah pernah diupload.'], 409);
        }

        
        $file = $req->file('proof');

        
        $fileName = 'Transfer_' . $user->id . '_' . $property->id . '_' . time() . '.' . $file->getClientOriginalExtension();

        
        $path = $file->storeAs('bukti_transfer', $fileName, 'public');
        

        if (!$path) {
            return response()->json(['message' => 'Gagal menyimpan file.'], 500);
        }

        
        $harga = $property->price;
        $fee   = $harga * 0.05;
        $code  = $user->id + $property->id + 100;
        $total = $harga + $fee + $code;

        
        $tx = PropertyCheckoutTransaction::create([
            'user_id' => $user->id,
            'property_id' => $property->id,
            'harga_properti' => $harga,
            'biaya_jasa' => $fee,
            'kode_unik' => $code,
            'total_transfer' => $total,
            'status_transaksi' => 'uploaded',
            'transaction_time' => now(),
            'bukti_transfer_url' => Storage::url($path),
        ]);

        return response()->json([
            'message' => 'Bukti transfer berhasil diunggah.',
            'transaction_id' => $tx->id,
            'bukti_transfer_url' => $tx->bukti_transfer_url,
            'property' => $property,
            'status' => $tx->status_transaksi
        ]);
        
        
    }

    public function getCheckoutTransactionById($transactionId)
    {
        
        $transaction = PropertyCheckoutTransaction::with('property')->find($transactionId);

        
        if (!$transaction) {
            return response()->json(['message' => 'Transaksi tidak ditemukan.'], 404);
        }
        
        
        
        
        

        
        
        return response()->json([
            'id' => $transaction->id,
            'property_id' => $transaction->property_id,
            'status' => $transaction->status_transaksi, 
            'created_at' => $transaction->created_at, 
            'property' => $transaction->property 
        ]);
    }

    public function getFavorites()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Silakan login untuk melihat favorit.'], 401);
        }

        $favoriteProperties = $user->properties()
            ->whereDoesntHave('propertyCheckoutTransactions', function ($query) {
                $query->whereIn('status_transaksi', ['uploaded', 'verified']);
            })
            ->get();

       return response()->json($favoriteProperties);
    }

    public function toggleFavorite(Request $request, Property $property)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Silakan login untuk menambahkan ke favorit.'], 401);
        }

        
        $isFavorited = $user->properties()->toggle($property->id);

        return response()->json([
            'message' => count($isFavorited['attached']) > 0
                ? 'Properti ditambahkan ke favorit.'
                : 'Properti dihapus dari favorit.',
            'isFavorited' => count($isFavorited['attached']) > 0
        ]);
    }

    public function getAllPropertiesApi()
    {
        $properties = Property::with(['amenities', 'developer', 'images'])
            ->whereDoesntHave('propertyCheckoutTransactions', function ($q) {
                $q->whereIn('status_transaksi', ['verified', 'uploaded']);
            })
            ->get();
    
        return response()->json($properties);
    }

    public function getTransactionHistory(Request $request)
    {
        $user = $request->user(); 

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $transactions = $user->transactions()->with('property')->get();

        $processVerificationTransactions = $transactions->where('status_transaksi', 'uploaded')->values();
        $purchasedTransactions = $transactions->where('status_transaksi', 'verified')->values();

        return response()->json([
            'Process_Verification' => $processVerificationTransactions,
            'Purchased_Transactions' => $purchasedTransactions,
        ]);
    }

}
<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyCheckoutTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PropertyCheckoutController extends Controller
{
     
    public function checkout(Request $request, Property $property)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'tolong login terlebih dahulu');
        }

        $user = Auth::user();

        $lockedInfo = $request->session()->get('lock_checkout_info');
        $property->refresh();

        if (
            !$lockedInfo ||
            $lockedInfo['property_id'] !== $property->id ||
            $lockedInfo['user_id'] !== $user->id ||
            $property->locked_by_user_id !== $user->id ||
            !$property->locked_until ||
            $property->locked_until->isPast()
        ) {
            $request->session()->forget('lock_checkout_info');
            return redirect()->route('property.show', $property->id)->withErrors([
                'checkout_error' => 'Checkout session is invalid or has expired. Please re-lock the property to continue.'
            ]);
        }

        $latestTransaction = PropertyCheckoutTransaction::where('user_id', $user->id)
            ->where('property_id', $property->id)
            ->whereIn('status_transaksi', ['uploaded', 'confirmed', 'processing', 'completed', 'rejected'])
            ->latest()
            ->first();

        if ($latestTransaction) {
            if ($latestTransaction->status_transaksi === 'rejected') {
                return redirect()->route('payment.rejected', ['transactionId' => $latestTransaction->id]);
            }

            return redirect()->route('payment.confirmation', ['transaction' => $latestTransaction->id]);
        }

        $propertyPrice = $property->price;
        $serviceFee = $propertyPrice * 0.05;
        $uniqueCode = $user->id + $property->id + 100;
        $totalAmount = $propertyPrice + $serviceFee + $uniqueCode;

        return view('paymentdetail', [
            'property' => $property,
            'hargaProperti' => $propertyPrice,
            'biayaLayanan' => $serviceFee,
            'kodeUnik' => $uniqueCode,
            'jumlahTotal' => $totalAmount,
            'locked_until_timestamp' => $property->locked_until->timestamp,
        ]);
    }

     
    public function uploadProof(Request $request, Property $property)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk mengunggah bukti transfer.');
        }

        $user = Auth::user();

        $request->validate([
            'proof' => 'required|file|mimes:jpeg,jpg,png,pdf|max:5120',
        ], [
            'proof.required' => 'File bukti bayar wajib diunggah.',
            'proof.file' => 'File tidak valid.',
            'proof.mimes' => 'Format file tidak didukung. Gunakan jpeg, jpg, png, atau pdf.',
            'proof.max' => 'Ukuran file maksimal 5MB. File kamu kegedean, tolong dikecilin.',
        ]);

        $property->refresh();

        
        if (!$property->locked_until || $property->locked_until->isPast() || $property->locked_by_user_id !== $user->id) {
            $request->session()->forget('lock_checkout_info');
            return redirect()->route('property.show', $property->id)
                            ->withErrors(['upload_error' => 'Sesi checkout sudah habis atau properti tidak dikunci oleh Anda. Silakan kunci ulang.']);
        }

        $existingTransaction = PropertyCheckoutTransaction::where('user_id', $user->id)
            ->where('property_id', $property->id)
            ->whereIn('status_transaksi', ['uploaded', 'rejected'])
            ->first();

        if ($existingTransaction) {
            if ($existingTransaction->status_transaksi === 'rejected') {
                return redirect()->route('payment.rejected', ['transactionId' => $existingTransaction->id]);
            }

            return redirect()->route('payment.confirmation', ['transaction' => $existingTransaction->id])
                            ->with('info', 'Anda sudah pernah mengunggah bukti untuk properti ini.');
        }

        $propertyPrice = $property->price;
        $serviceFee = $propertyPrice * 0.05;
        $uniqueCode = $user->id + $property->id + 100;
        $totalAmount = $propertyPrice + $serviceFee + $uniqueCode;

        $file = $request->file('proof');
        $fileName = 'Transfer_' . $user->id . '_' . $property->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('bukti_transfer', $fileName, 'public');

        if (!$path) {
            return redirect()->back()->withErrors(['upload_error' => 'Gagal menyimpan file. Silakan coba lagi.']);
        }

        $transaction = PropertyCheckoutTransaction::create([
            'user_id' => $user->id,
            'property_id' => $property->id,
            'harga_properti' => $propertyPrice,
            'biaya_jasa' => $serviceFee,
            'kode_unik' => $uniqueCode,
            'total_transfer' => $totalAmount,
            'status_transaksi' => 'uploaded',
            'transaction_time' => now(),
            'bukti_transfer_url' => Storage::url($path),
        ]);

        $request->session()->forget('lock_checkout_info');

        return redirect()->route('payment.confirmation', ['transaction' => $transaction->id])
                        ->with('success', 'Bukti transfer berhasil diunggah.');
    }

    public function paymentConfirmation(Request $request, $transactionId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        $transaction = PropertyCheckoutTransaction::find($transactionId);

        if (!$transaction) {
            return redirect()->route('home')->with('error', 'Transaksi tidak ditemukan.');
        }

        if ($transaction->user_id !== $user->id) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke transaksi ini.');
        }

        if ($transaction->status_transaksi === 'rejected') {
            return redirect()->route('payment.rejected', ['transactionId' => $transaction->id]);
        }

        if ($transaction->status_transaksi === 'verified') {
            return redirect()->route('payment.confirmed', ['transactionId' => $transaction->id]);
        }

        return view('paymentconfirmation', compact('transaction'));
    }

    public function confirmedPage($transactionId)
    {
        $transaction = PropertyCheckoutTransaction::find($transactionId);

        if (!$transaction) {
            return redirect()->route('home')->with('error', 'Transaksi tidak ditemukan.');
        }

          
        if ($transaction->status_transaksi === 'rejected') {
            return redirect()->route('payment.rejected', ['transactionId' => $transaction->id]);
        }

         
        if (!in_array($transaction->status_transaksi, ['verified', 'completed'])) {
              
             return redirect()->route('payment.confirmation', ['transaction' => $transaction->id])->with('error', 'Transaksi belum dikonfirmasi.');
        }

        return view('paymentconfirmed', compact('transaction'));
    }

    public function paymentRejected($transactionId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        $transaction = PropertyCheckoutTransaction::find($transactionId);

        if (!$transaction) {
            return redirect()->route('home')->with('error', 'Transaksi tidak ditemukan.');
        }

        if ($transaction->user_id !== $user->id) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke transaksi ini.');
        }

        if ($transaction->status_transaksi !== 'rejected') {
            return redirect()->route('payment.confirmation', ['transaction' => $transaction->id])
                            ->with('error', 'Transaksi ini tidak berstatus ditolak.');
        }

        return view('paymentrejected', compact('transaction'));
    }
}

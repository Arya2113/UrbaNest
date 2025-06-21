<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyCheckoutTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PropertyCheckoutController extends Controller
{
     
     
    public function checkout(Request $request, Property $property)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk melanjutkan.');
        }
        $user = Auth::user();

        $lockInfo = $request->session()->get('lock_checkout_info');
        $property->refresh();  

         
         
         
         
        if (!$lockInfo ||
            $lockInfo['property_id'] !== $property->id ||
            $lockInfo['user_id'] !== $user->id ||  
            $property->locked_by_user_id !== $user->id ||
            !$property->locked_until ||
            $property->locked_until->isPast()) {

             
            $request->session()->forget('lock_checkout_info');
            return redirect()->route('property.show', $property->id)->withErrors(['checkout_error' => 'Sesi checkout tidak valid atau telah kedaluwarsa. Silakan kunci ulang properti untuk melanjutkan.']);
        }

         
         
        $existingTransaction = PropertyCheckoutTransaction::where('user_id', $user->id)
            ->where('property_id', $property->id)
            ->whereIn('status_transaksi', ['uploaded', 'confirmed', 'processing', 'completed', 'rejected'])  
            ->latest()
            ->first();

        if ($existingTransaction) {
              
             if ($existingTransaction->status_transaksi === 'rejected') {
                 return redirect()->route('payment.rejected', ['transactionId' => $existingTransaction->id]);
             }
             
            return redirect()->route('payment.confirmation', ['transaction' => $existingTransaction->id]);
        }


         
        $hargaProperti = $property->price;
        $biayaLayanan = $hargaProperti * 0.05;  
         
         
         
        $kodeUnik = $user->id + $property->id + 100;  
        $jumlahTotal = $hargaProperti + $biayaLayanan + $kodeUnik;

        return view('paymentdetail', [
            'property' => $property,
            'hargaProperti' => $hargaProperti,
            'biayaLayanan' => $biayaLayanan,
            'kodeUnik' => $kodeUnik,
            'jumlahTotal' => $jumlahTotal,
            'locked_until_timestamp' => $property->locked_until->timestamp,  
        ]);
    }

     
    public function uploadProof(Request $request, Property $property)
    {
        if (!Auth::check()) {
            return $request->expectsJson()
                ? response()->json(['message' => 'Silakan login untuk mengunggah bukti transfer.'], 401)
                : redirect()->route('login')->with('error', 'Silakan login untuk mengunggah bukti transfer.');
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

        try {
            $transactionResult = DB::transaction(function () use ($request, $property, $user) {
                 
                $freshProperty = Property::where('id', $property->id)->lockForUpdate()->first();

                if (!$freshProperty) {
                    return ['success' => false, 'message' => 'Properti tidak ditemukan.', 'status' => 404, 'redirect_route' => 'home'];  
                }

                 
                if (!$freshProperty->locked_until || $freshProperty->locked_until->isPast() || $freshProperty->locked_by_user_id !== $user->id) {
                    $request->session()->forget('lock_checkout_info');  
                    return ['success' => false, 'message' => 'Waktu checkout telah habis atau properti tidak lagi dikunci oleh Anda. Silakan coba kunci ulang.', 'status' => 409, 'redirect_route' => 'property.show', 'property_id' => $freshProperty->id];
                }

                 
                $existingTransaction = PropertyCheckoutTransaction::where('user_id', $user->id)
                    ->where('property_id', $freshProperty->id)
                    ->whereIn('status_transaksi', ['uploaded', 'rejected'])
                    ->first();

                if ($existingTransaction) {
                      
                     if ($existingTransaction->status_transaksi === 'rejected') {
                         return ['success' => false, 'redirect_route' => 'payment.rejected', 'transaction_id' => $existingTransaction->id];
                     }
                    return ['success' => false, 'message' => 'Anda sudah pernah mengunggah bukti untuk properti ini.', 'status' => 409, 'redirect_route' => 'payment.confirmation'];  
                }

                 
                $hargaProperti = $freshProperty->price;
                $biayaLayanan = $hargaProperti * 0.05;
                 
                $kodeUnik = $user->id + $freshProperty->id + 100;  
                $jumlahTotal = $hargaProperti + $biayaLayanan + $kodeUnik;

                $file = $request->file('proof');
                $fileName = 'Transfer_' . $user->id . '_' . $freshProperty->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('bukti_transfer', $fileName, 'public');

                if (!$path) {
                     
                    Log::error("File storage failed for user {$user->id}, property {$freshProperty->id}.");
                    throw new \Exception('Gagal menyimpan file bukti transfer. Penyimpanan file bermasalah.');
                }

                $newTransaction = PropertyCheckoutTransaction::create([
                    'user_id' => $user->id,
                    'property_id' => $freshProperty->id,
                    'harga_properti' => $hargaProperti,
                    'biaya_jasa' => $biayaLayanan,
                    'kode_unik' => $kodeUnik,
                    'total_transfer' => $jumlahTotal,
                    'status_transaksi' => 'uploaded',  
                    'transaction_time' => Carbon::now(),
                    'bukti_transfer_url' => Storage::url($path),
                     
                ]);

                 
                $request->session()->forget('lock_checkout_info');

                 
                 
                 

                return ['success' => true, 'transaction_id' => $newTransaction->id, 'redirect_route' => 'payment.confirmation'];
            });

            if ($transactionResult['success']) {
                 if (isset($transactionResult['transaction_id'])) {
                      return redirect()->route(
                          $transactionResult['redirect_route'],
                          ['transaction' => $transactionResult['transaction_id']]
                      );
                 } else {
                       return redirect()->route(
                           $transactionResult['redirect_route']
                       );
                 }
            } else {
                $redirectRoute = $transactionResult['redirect_route'] ?? 'property.checkout';
                $routeParameters = isset($transactionResult['property_id']) ? $transactionResult['property_id'] : $property->id;

                 
                if ($redirectRoute === 'payment.rejected' && isset($transactionResult['transaction_id'])) {
                    return redirect()->route($redirectRoute, ['transactionId' => $transactionResult['transaction_id']]);
                }

                if ($request->expectsJson()) {
                    return response()->json(['message' => $transactionResult['message']], $transactionResult['status']);
                }
                return redirect()->route($redirectRoute, $routeParameters)
                                 ->withInput()
                                 ->withErrors(['upload_error' => $transactionResult['message']]);
            }

        } catch (ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Data tidak valid.', 'errors' => $e->errors()], 422);
            }
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error uploading proof and creating transaction: UserID ' . ($user->id ?? 'guest') . ' PropertyID ' . $property->id . ' - ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Gagal mengunggah bukti transfer karena kesalahan sistem. Silakan coba lagi nanti.'], 500);
            }
             
            return redirect()->route('property.checkout', $property->id)->withInput()->withErrors(['upload_error' => 'Terjadi kesalahan tidak terduga saat mengunggah bukti transfer. Tim kami telah diberitahu. Silakan coba lagi nanti atau hubungi dukungan.']);
        }
    }

    public function paymentConfirmation(Request $request, $transactionId)
    {
        $transaction = PropertyCheckoutTransaction::find($transactionId);

        if (!$transaction) {
            return redirect()->route('home')->with('error', 'Transaksi tidak ditemukan.');
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
        $transaction = PropertyCheckoutTransaction::find($transactionId);

        if (!$transaction) {
            return redirect()->route('home')->with('error', 'Transaksi tidak ditemukan.');
        }

         
        if ($transaction->status_transaksi !== 'rejected') {
              
             return redirect()->route('payment.confirmation', ['transaction' => $transaction->id])->with('error', 'Transaksi ini tidak berstatus ditolak.');
        }

        return view('paymentrejected', compact('transaction'));
    }
}

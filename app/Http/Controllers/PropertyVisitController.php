<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PropertyVisit;
use App\Models\Property;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;  

class PropertyVisitController extends Controller
{
    public function store(Request $request, Property $property): JsonResponse  
    {
         
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Anda harus login untuk menjadwalkan kunjungan.'
            ], 401);  
        }

        try {
             
            $validatedData = $request->validate([
                'scheduled_at' => 'required|date|after_or_equal:today',
            ]);

             
            $visit = new PropertyVisit();
            $visit->user_id = Auth::id();
            $visit->property_id = $property->id;
            $visit->scheduled_at = $validatedData['scheduled_at'];  
            $visit->status = 'pending';  
            $visit->save();

             
            return response()->json([
                'message' => 'Kunjungan properti berhasil dijadwalkan. Kami akan menghubungi Anda segera untuk konfirmasi.',
                'visit_id' => $visit->id  
            ], 200);  
        } catch (\Illuminate\Validation\ValidationException $e) {
             
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422);  
        } catch (\Exception $e) {
             
            return response()->json([
                'message' => 'Terjadi kesalahan saat menjadwalkan kunjungan. Silakan coba lagi nanti.',
                'error' => $e->getMessage()
            ], 500);  
        }
    }

    public function destroy(PropertyVisit $visit)
    {
        $visit->delete();
        return redirect()->back()->with('success', 'Kunjungan berhasil dihapus.');
    }

    public function userVisits()
    {   
        try {
            $kunjungan = PropertyVisit::with('property')->where('user_id', Auth::id())->get();
            Log::info("Kunjungan ditemukan: ", $kunjungan->toArray());
            return response()->json($kunjungan);
        } catch (\Exception $e) {
            Log::error("Gagal mengambil data kunjungan: " . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan'], 500);
        }
    }
}
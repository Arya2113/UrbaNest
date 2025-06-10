<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PropertyVisit;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse; // Penting: Impor JsonResponse

class PropertyVisitController extends Controller
{
    /**
     * Store a newly created property visit in storage.
     */
    public function store(Request $request, Property $property): JsonResponse // Tentukan tipe kembalian JsonResponse
    {
        // Pastikan pengguna sudah login
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Anda harus login untuk menjadwalkan kunjungan.'
            ], 401); // 401 Unauthorized
        }

        try {
            // Validasi permintaan
            $validatedData = $request->validate([
                'scheduled_at' => 'required|date|after_or_equal:today',
            ]);

            // Buat entri kunjungan baru
            $visit = new PropertyVisit();
            $visit->user_id = Auth::id();
            $visit->property_id = $property->id;
            $visit->scheduled_at = $validatedData['scheduled_at']; // Gunakan data yang divalidasi
            $visit->status = 'pending'; // Default status
            $visit->save();

            // Kembalikan respons JSON yang sukses
            return response()->json([
                'message' => 'Kunjungan properti berhasil dijadwalkan. Kami akan menghubungi Anda segera untuk konfirmasi.',
                'visit_id' => $visit->id // Opsional: kembalikan ID kunjungan yang baru dibuat
            ], 200); // 200 OK
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Tangani error validasi dan kembalikan JSON dengan error 422
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422); // 422 Unprocessable Entity
        } catch (\Exception $e) {
            // Tangani error umum lainnya dan kembalikan JSON dengan error 500
            return response()->json([
                'message' => 'Terjadi kesalahan saat menjadwalkan kunjungan. Silakan coba lagi nanti.',
                'error' => $e->getMessage()
            ], 500); // 500 Internal Server Error
        }
    }
}
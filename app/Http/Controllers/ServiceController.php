<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Tampilkan landing page services (overview/list jasa)
     */
    public function index()
    {
        // Bisa kirim data tambahan jika perlu
        return view('servicesPage');
    }

    /**
     * Tampilkan form request service
     */
    public function showForm()
    {
        return view('servicesForm');
    }

    /**
     * Proses form request service
     */
    public function submitRequest(Request $request)
    {
        $validated = $request->validate([
            'full_name'    => 'required|string|max:255',
            'email'        => 'required|email|max:255',
            'phone'        => 'nullable|string|max:30',
            'location'     => 'required|string|max:255',
            'service_type' => 'required|string',
            'budget'       => 'nullable|numeric',
            'timeline'     => 'nullable|date',
            'description'  => 'nullable|string',
            'terms'        => 'accepted'
        ]);

        // Simpan ke database jika ada model, atau kirim email, dll.
        // ServiceRequest::create($validated);

        return redirect()->back()->with('success', 'Your service request has been submitted. Our team will contact you soon.');
    }
}

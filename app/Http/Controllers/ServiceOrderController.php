<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceOrder;

class ServiceOrderController extends Controller
{
    public function index()
    {
        $orders = ServiceOrder::with(['user', 'architect'])->latest()->get();
        return view('service_orders.index', compact('orders'));
    }

    public function create()
    {
        // Kirim data arsitek jika perlu dropdown arsitek
        $architects = \App\Models\Architect::all();
        return view('service_orders.create', compact('architects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'            => 'required|exists:users,id',
            'architect_id'       => 'nullable|exists:architects,id',
            'full_name'          => 'required|string|max:255',
            'email'              => 'required|email|max:255',
            'phone_number'       => 'required|string|max:20',
            'project_location'   => 'required|string|max:255',
            'project_type'       => 'required|string|max:255',
            'estimated_budget'   => 'nullable|numeric',
            'project_date'       => 'nullable|date',
            'project_description'=> 'nullable|string',
            'status'             => 'nullable|string|max:50',
        ]);

        ServiceOrder::create($validated);

        return redirect()->route('service_orders.index')->with('success', 'Order berhasil dibuat!');
    }

    public function show(ServiceOrder $serviceOrder)
    {
        return view('service_orders.show', compact('serviceOrder'));
    }

    public function edit(ServiceOrder $serviceOrder)
    {
        $architects = \App\Models\Architect::all();
        return view('service_orders.edit', compact('serviceOrder', 'architects'));
    }

    public function update(Request $request, ServiceOrder $serviceOrder)
    {
        $validated = $request->validate([
            'architect_id'       => 'nullable|exists:architects,id',
            'full_name'          => 'required|string|max:255',
            'email'              => 'required|email|max:255',
            'phone_number'       => 'required|string|max:20',
            'project_location'   => 'required|string|max:255',
            'project_type'       => 'required|string|max:255',
            'estimated_budget'   => 'nullable|numeric',
            'project_date'       => 'nullable|date',
            'project_description'=> 'nullable|string',
            'status'             => 'nullable|string|max:50',
        ]);

            // Simpan ke database (pakai model ServiceOrder)
        $order = \App\Models\ServiceOrder::create([
            'user_id'            => auth()->id(),
            'full_name'          => $validated['full_name'],
            'email'              => $validated['email'],
            'phone_number'       => $validated['phone'],
            'project_location'   => $validated['location'],
            'project_type'       => $validated['service_type'],
            'estimated_budget'   => $validated['budget'],
            'project_date'       => $validated['timeline'],
            'project_description'=> $validated['description'],
            // 'architect_id'    => null,
            'status'             => 'pending',
        ]);

        // Simpan ID order ke session (agar setelah pilih arsitek, bisa update order ini)
        session(['last_service_order_id' => $order->id]);

    return redirect()->route('architectsPage');

        $serviceOrder->update($validated);

        return redirect()->route('service_orders.index')->with('success', 'Order berhasil diupdate!');
    }

    public function destroy(ServiceOrder $serviceOrder)
    {
        $serviceOrder->delete();
        return redirect()->route('service_orders.index')->with('success', 'Order berhasil dihapus!');
    }
}

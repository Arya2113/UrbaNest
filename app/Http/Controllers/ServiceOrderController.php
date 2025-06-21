<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ServiceOrder;
use App\Models\Architect;


class ServiceOrderController extends Controller
{
    public function index()
    {
        $orders = ServiceOrder::with(['user', 'architect'])->latest()->get();
        return view('service_orders.index', compact('orders'));
    }

    public function create()
    {
         
        $architects = \App\Models\Architect::all();
        return view('service_orders.create', compact('architects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([           
            'full_name'          => 'required|string|max:255',
            'email'              => 'required|email|max:255',
            'phone_number'       => 'required|string|max:20',
            'project_location'   => 'required|string|max:255',
            'service_type'       => 'required|in:construction,renovation,design',  
            'estimated_budget'   => 'nullable|numeric',
            'project_date'       => 'nullable|date',
            'project_description'=> 'nullable|string',
        ]);

         
        $order = ServiceOrder::create([
            'user_id'            => auth()->id(),
            'full_name'          => $validated['full_name'],
            'email'              => $validated['email'],
            'phone_number'       => $validated['phone_number'],
            'project_location'   => $validated['project_location'],
            'service_type'       => $validated['service_type'], 
            'estimated_budget'   => $validated['estimated_budget'] ?? null,
            'project_date'       => $validated['project_date'] ?? null,
            'project_description'=> $validated['project_description'] ?? null,
            'status'             => 'pending',
        ]);

        if (!$order) {
            return back()->with('error', 'Order gagal disimpan.');
        }

        session(['last_service_order_id' => $order->id]);

        return redirect()->route('architectsPage')->with('success', 'Order berhasil dibuat! Silakan pilih arsitek.');
    }
    
    public function show($orderId)
    {   
        $order = \App\Models\ServiceOrder::with('architect')->findOrFail($orderId);

        $serviceType = strtolower($order->service_type);

        $timelines = [
            'construction' => [
                'title' => 'Urbanest Konstruksi',
                'steps' => [
                    'Menghubungi Arsitek',
                    'Kunjungan Lokasi',
                    'Finalisasi Desain',
                    'Mulai Konstruksi',
                    'Konstruksi Selesai',
                ],
            ],
            'renovation' => [
                'title' => 'Urbanest Renovasi',
                'steps' => [
                    'Diskusi Dengan Arsitek',
                    'Survey Lokasi',
                    'Sketsa Renovasi',
                    'Pelaksanaan Renovasi',
                    'Renovasi Selesai',
                ],
            ],
            'design' => [
                'title' => 'Urbanest Desain',
                'steps' => [
                    'Diskusi Kebutuhan',
                    'Referensi Desain',
                    'Pembuatan Draft',
                    'Revisi Desain',
                    'Finalisasi Desain',
                ],
            ]
        ];

        $timelineInfo = $timelines[$serviceType] ?? [
            'title' => 'Urbanest Proyek',
            'steps' => ['Tahap 1', 'Tahap 2', 'Tahap 3', 'Tahap 4', 'Tahap 5'],
        ];

         
        $statusIndex = array_search($order->status, ['pending','consultation','site_survey','designing','in_progress','review','completed']);
        $progressStep = min(max($statusIndex, 0), 4);  
        $progressPercent = $progressStep * 20;

        $timeline = [];
        foreach ($timelineInfo['steps'] as $i => $stepTitle) {
            $timeline[] = [
                'title' => $stepTitle,
                'date' => now()->addDays($i * 5)->format('Y-m-d'),
                'done' => $i < $progressStep,
                'active' => $i === $progressStep,
            ];
        }

        return view('serviceOrderStatus', [
            'order' => $order,
            'progressPercent' => $progressPercent,
            'timeline' => $timeline,
            'judulProyek' => $timelineInfo['title'],
        ]);
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
            'service_type'       => 'required|string|max:255',
            'estimated_budget'   => 'nullable|numeric',
            'project_date'       => 'nullable|date',
            'project_description'=> 'nullable|string',
            'status'             => 'nullable|string|max:50',
        ]);

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

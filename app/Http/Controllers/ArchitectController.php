<?php

namespace App\Http\Controllers;

use App\Models\Architect;
use App\Models\ServiceOrder;
use Illuminate\Http\Request;

class ArchitectController extends Controller
{
    public function index(Request $request)
    {
        $query = Architect::query();

        if ($request->has('style') && $request->style !== 'all') {
            $query->whereJsonContains('styles', $request->style);
        }

        $architects = $query->get();

        $allStyles = Architect::pluck('styles')
            ->flatten()
            ->unique()
            ->sort()
            ->values();

        return view('architectsPage', compact('architects', 'allStyles'));
    }

     
    public function selectArchitect(Request $request)
    {
    
        $request->validate([
            'architect_id' => 'required|exists:architects,id',
        ]);
    
        $orderId = session('last_service_order_id');
        if (!$orderId) {
            return redirect()->route('services.page')->with('error', 'Tidak ada order yang ditemukan');
        }
    
        $order = ServiceOrder::find($orderId);
        if (!$order) {
            return redirect()->route('services.page')->with('error', 'Order tidak ditemukan!');
        }
        
         
        $order->architect_id = $request->architect_id;
        $order->status = 'consultation';
        $order->save();
    
        session()->forget('last_service_order_id');
        
        return redirect()->route('order.status.show', $order->id)
            ->with('success', 'arsitek berhasil dipilih');
    }


    public function dashboard()
    {
        $architect = auth()->user()->architect;

        if (!$architect) {
            return redirect()->route('architect.login')->withErrors([
                'msg' => 'Profil arsitek tidak ditemukan.'
            ]);
        }

        $serviceOrders = ServiceOrder::where('architect_id', $architect->id)
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('architect.dashboard', compact('serviceOrders'));
    }


    
    public function updateStatus(Request $request, ServiceOrder $serviceOrder)
    {
        $architect = auth()->user()->architect;

        if (!$architect || $serviceOrder->architect_id !== $architect->id) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'status' => 'required|in:pending,consultation,site_survey,designing,in_progress,review,completed,cancelled',
        ]);

        $serviceOrder->status = $request->status;
        $serviceOrder->save();

        return redirect()->back()->with('success', 'status berhasil diupdate');
    }
    
}

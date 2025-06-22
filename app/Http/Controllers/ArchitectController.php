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
        \Log::info('MASUK selectArchitect()', [
            'request' => $request->all(),
            'session_last_service_order_id' => session('last_service_order_id'),
        ]);
    
        $request->validate([
            'architect_id' => 'required|exists:architects,id',
        ]);
    
        $orderId = session('last_service_order_id');
        if (!$orderId) {
            \Log::error('orderId KOSONG!', [
                'session' => session()->all()
            ]);
            return redirect()->route('services.page')->with('error', 'No active order found. Please start your request again.');
        }
    
        $order = ServiceOrder::find($orderId);
        if (!$order) {
            \Log::error('ORDER NOT FOUND!', ['orderId' => $orderId]);
            return redirect()->route('services.page')->with('error', 'Order tidak ditemukan!');
        }
    
        \Log::info('ORDER DITEMUKAN!', ['orderId' => $orderId, 'architect_id' => $request->architect_id]);
    
         
        $order->architect_id = $request->architect_id;
        $order->status = 'consultation';
        $order->save();
    
        session()->forget('last_service_order_id');
    
        \Log::info('ORDER UPDATED!', ['orderId' => $orderId, 'order' => $order->toArray()]);
    
        return redirect()->route('order.status.show', $order->id)
            ->with('success', 'Architect selected successfully! Your project is now in consultation stage.');
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

        return redirect()->back()->with('success', 'Status updated successfully.');
    }
    
}

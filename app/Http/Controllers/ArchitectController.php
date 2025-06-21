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
    
}

<?php

namespace App\Http\Controllers;

use App\Models\Architect;
use Illuminate\Http\Request;

class ArchitectController extends Controller
{
    public function index(Request $request)
    {
        $query = Architect::query();

        // Optional filter
        if ($request->has('style')) {
            $query->whereJsonContains('styles', $request->style);
        }

        $architects = $query->get();

        return view('architectsPage', compact('architects'));
    }
}

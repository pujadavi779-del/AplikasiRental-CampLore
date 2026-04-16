<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with(['products', 'user'])->get()->map(fn($o) => [
            'id'       => '#ORD-' . str_pad($o->id, 3, '0', STR_PAD_LEFT),
            'name'     => $o->user->name,
            'email'    => $o->user->email,
            'av'       => strtoupper(
                substr($o->user->name, 0, 1) .
                    substr($o->user->name, strpos($o->user->name, ' ') + 1, 1)
            ),
            'products' => $o->products->map(fn($p) => [
                'name' => $p->name,
                'type' => $p->type
            ]),
            'price'    => $o->total_price,
            'days'     => $o->duration_days,
            'status'   => $o->status,
            'date'     => $o->created_at->format('Y-m-d'),
        ]);

        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        $order->delete();

        return response()->json([
            'message' => 'Berhasil dihapus'
        ]);
    }
}

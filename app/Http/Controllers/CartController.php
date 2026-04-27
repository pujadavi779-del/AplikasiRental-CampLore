<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with('item')
            ->where('user_id', Auth::id())
            ->get();

        return view('pages.landing.cart', compact('carts'));
    }

    public function add(Request $request)
    {
        $cart = Cart::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'item_id' => $request->item_id,
            ],
            [
                'quantity'   => $request->quantity,
                'start_date' => $request->start_date,
                'end_date'   => $request->end_date,
            ]
        );

        return response()->json([
            'success' => true,
            'cart_id' => $cart->id,
            'total'   => Cart::where('user_id', auth()->id())->count(),
        ]);
    }

    public function update(Request $request, $cartId)
    {
        $cart = Cart::where('id', $cartId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($request->has('quantity')) {
            $cart->quantity = max(1, (int) $request->quantity);
        }

        if ($request->has('start_date')) {
            $cart->start_date = $request->start_date;
        }

        if ($request->has('end_date')) {
            $cart->end_date = $request->end_date;
        }

        $cart->save();

        return response()->json(['success' => true]);
    }

    public function destroy($cartId)
    {
        Cart::where('id', $cartId)
            ->where('user_id', Auth::id())
            ->delete();

        return response()->json([
            'success' => true,
            'total'   => Cart::where('user_id', Auth::id())->count(),
        ]);
    }

    public function bulkDestroy(Request $request)
    {
        Cart::whereIn('id', $request->ids)
            ->where('user_id', Auth::id())
            ->delete();

        return response()->json([
            'success' => true,
            'total'   => Cart::where('user_id', Auth::id())->count(),
        ]);
    }
}

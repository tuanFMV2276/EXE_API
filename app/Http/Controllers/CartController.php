<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function index()
    {
        $orderDetails = Cart::with(['user', 'product'])->get();

        return response()->json([
            'status' => 'success',
            'data' => $orderDetails
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'size' => 'required|string',
            'color' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
            'is_select' => 'nullable|in:0,1',

        ]);

        $cart = Cart::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Cart created successfully',
            'data' => $cart
        ], 201);
    }

    public function show($id)
    {
        $cart = Cart::with(['user', 'product'])->find($id);

        if (!$cart) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cart not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $cart
        ]);
    }

    /**
     * Update the specified order detail in storage.
     */
    // public function update(Request $request, $id)
    // {
    //     $cart = Cart::find($id);

    //     if (!$cart) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Cart not found'
    //         ], 404);
    //     }

    //     $validated = $request->validate([
    //         'user_id' => 'sometimes|required|exists:users,id',
    //         'product_id' => 'sometimes|required|exists:products,id',
    //         'size' => 'required|string',
    //         'color' => 'required|string',
    //         'quantity' => 'sometimes|required|integer|min:1',
    //         'total_price' => 'sometimes|required|numeric|min:0',
    //         'is_select' => 'nullable|in:0,1',

    //     ]);

    //     $cart->update($validated);

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Cart updated successfully',
    //         'data' => $cart
    //     ]);
    // }

    public function update(Request $request, $id)
    {
        $cart = Cart::find($id);
        if (!$cart) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cart not found'
            ], 404);
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart->update([
            'quantity' => $validated['quantity']
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Cart quantity updated successfully',
            'data' => $cart
        ]);
    }


    /**
     * Remove the specified order detail from storage.
     */
    public function destroy($id)
    {
        $orderDetail = Cart::find($id);

        if (!$orderDetail) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cart not found'
            ], 404);
        }

        $orderDetail->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Cart deleted successfully'
        ], 200);
    }
}

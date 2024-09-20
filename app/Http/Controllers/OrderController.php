<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['orderDetails', 'user'])->get();

        return response()->json([
            'status' => 'success',
            'data' => $orders
        ]);
    }

    // 'customer_id',
    //     'total_amount',
    //     'full_name',
    //     'shipping_address',
    //     'phone',
    //     'payment_method',
    //     'status'
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:users,id',
            'total_amount' => 'required|numeric',
            'full_name' => 'required|string',
            'shipping_address' => 'required|string',
            'phone' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        $order = Order::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Order created successfully',
            'data' => $order
        ], 201);
    }

    public function show($id)
    {
        $order = Order::with(['orderDetails', 'user'])->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $order
        ]);
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'customer_id' => 'required|exists:users,id',
            'total_amount' => 'required|numeric',
            'full_name' => 'required|string',
            'shipping_address' => 'required|string',
            'phone' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        $order->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Order updated successfully',
            'data' => $order
        ], 200);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Order deleted successfully'
        ], 204);
    }
}
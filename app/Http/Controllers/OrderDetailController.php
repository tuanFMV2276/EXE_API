<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    /**
     * Display a listing of order details with related orders and products.
     */
    public function index()
    {
        $orderDetails = OrderDetail::with(['order', 'product'])->get();

        return response()->json([
            'status' => 'success',
            'data' => $orderDetails
        ]);
    }

    /**
     * Store a newly created order detail in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'size' => 'required|string',
            'color' => 'required|string',
            'quantity' => 'required|integer|min:1',
            // 'total_price' => 'required|numeric|min:0',
        ]);

        $orderDetail = OrderDetail::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Order detail created successfully',
            'data' => $orderDetail
        ], 201);
    }

    /**
     * Display the specified order detail with related order and product.
     */
    public function show($id)
    {
        $orderDetail = OrderDetail::with(['order', 'product'])->find($id);

        if (!$orderDetail) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order detail not found'   
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $orderDetail
        ]);
    }

    /**
     * Update the specified order detail in storage.
     */
    public function update(Request $request, $id)
    {
        $orderDetail = OrderDetail::find($id);

        if (!$orderDetail) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order detail not found'
            ], 404);
        }

        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'size' => 'required|string',
            'color' => 'required|string',
            'quantity' => 'required|integer|min:1',
            // 'total_price' => 'required|numeric|min:0',
            'status' => 'required|string'
        ]);

        $orderDetail->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Order detail updated successfully',
            'data' => $orderDetail
        ]);
    }

    /**
     * Remove the specified order detail from storage.
     */
    public function destroy($id)
    {
        $orderDetail = OrderDetail::find($id);

        if (!$orderDetail) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order detail not found'
            ], 404);
        }

        $orderDetail->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Order detail deleted successfully'
        ], 200);
    }
}
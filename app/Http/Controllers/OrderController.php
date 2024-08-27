<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Lấy tất cả đơn hàng cùng chi tiết đơn hàng và thông tin người dùng
        $orders = Order::with(['orderDetails', 'user'])->get();

        return response()->json([
            'status' => 'success',
            'data' => $orders
        ]);
    }

    public function store(Request $request)
    {
        // Validate dữ liệu đầu vào
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'total_price' => 'required|numeric',
            'status' => 'required|string',
        ]);

        // Tạo đơn hàng mới
        $order = Order::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Order created successfully',
            'data' => $order
        ], 201);
    }

    public function show($id)
    {
        // Lấy thông tin đơn hàng cùng chi tiết đơn hàng và người dùng
        $order = Order::with(['orderDetails', 'user'])->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $order
        ]);
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // Validate dữ liệu đầu vào
        $validated = $request->validate([
            'total_price' => 'sometimes|required|numeric',
            'status' => 'sometimes|required|string',
        ]);

        // Cập nhật đơn hàng
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
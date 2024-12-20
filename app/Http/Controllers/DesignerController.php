<?php

namespace App\Http\Controllers;

use App\Models\Designer;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DesignerController extends Controller
{
    public function index()
    {
        $designers = Designer::with('products',  'products.images', 'products.sizes', 'products.colors')->get();

        return response()->json([
            'status' => 'success',
            'data' => $designers
        ]);
    }

    public function getOrderFromCustomer($id)
    {
        $designers = Designer::with('products.orderDetails.order')->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $designers
        ]);
    }

    public function getOrdersForDesigner($designerId)
    {
        $designer = \App\Models\Designer::with(['products.orderDetails.order.user', 'products.images', 'products.sizes', 'products.colors'])
            ->findOrFail($designerId);

        $orderDetails = $designer->products->flatMap(function ($product) {
            return $product->orderDetails->map(function ($orderDetail) {
                return [
                    'order_detail_id' => $orderDetail->id ?? null,
                    'order_date' => $orderDetail->order->created_at ?? null,
                    'customer_name' => $orderDetail->order->full_name ?? 'N/A',
                    'phone' => $orderDetail->order->phone ?? 'N/A',
                    'address' => $orderDetail->order->shipping_address ?? 'N/A',
                    'product_name' => $orderDetail->product->product_name ?? 'N/A',
                    'product_size' => $orderDetail->size ?? null,
                    'product_color' => $orderDetail->color ?? null,
                    'product_image' => $orderDetail->product->images ?? null,
                    'payment_method' => $orderDetail->order->payment_method ?? 'N/A',
                    'price' => $orderDetail->product->price ?? 0,
                    'status' => $orderDetail->status ?? 'N/A',

                ];
            });
        });

        return response()->json([
            'status' => 'success',
            'data' => $orderDetails->filter()
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'full_name' => 'required|string|max:255',
            'contact_info' => 'required|string|max:255',
            'bio' => 'nullable|string',
        ]);

        $designer = Designer::create($validated);

        $user = \App\Models\User::findOrFail($validated['user_id']);
        $user->role = 'Designer';
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Designer created successfully',
            'data' => $designer
        ], 201);
    }

    // public function store(Request $request)
    // {
    //     $cutomer = Designer::create($request->all());
    //     return response()->json($cutomer, 201);
    // }

    public function show($id)
    {

        $designer = Designer::with('products', 'products.images', 'products.sizes', 'products.colors')->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $designer
        ]);
    }

    public function update(Request $request, $id)
    {
        $designer = Designer::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'required',
            'full_name' => 'sometimes|required|string|max:255',
            'contact_info' => 'sometimes|required|string|email|max:255|unique:designers,email,' . $designer->id,
            'bio' => 'nullable|string',
        ]);

        $designer->update($validated);


        return response()->json([
            'status' => 'success',
            'message' => 'Designer updated successfully',
            'data' => $designer
        ], 200);
    }


    public function updateStatusOrderDetail(Request $request, $id)
    {
        $orderDetail = OrderDetail::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|string',
        ]);

        $orderDetail->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Order updated successfully',
            'data' => $orderDetail
        ], 200);
    }

    public function destroy($id)
    {
        $designer = Designer::findOrFail($id);
        $designer->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Designer deleted successfully'
        ], 204);
    }
}

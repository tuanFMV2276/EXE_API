<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Lấy tất cả sản phẩm cùng thông tin nhà thiết kế và nhà cung ứng
        $products = Product::with(['designer', 'supplier'])->get();

        return response()->json([
            'status' => 'success',
            'data' => $products
        ]);
    }

    public function store(Request $request)
    {
        // Validate dữ liệu đầu vào
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'designer_id' => 'required|exists:designers,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
        ]);

        // Tạo sản phẩm mới
        $product = Product::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Product created successfully',
            'data' => $product
        ], 201);
    }

    public function show($id)
    {
        // Lấy thông tin sản phẩm cùng nhà thiết kế và nhà cung ứng
        $product = Product::with(['designer', 'supplier'])->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $product
        ]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Validate dữ liệu đầu vào
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric',
            'designer_id' => 'sometimes|required|exists:designers,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
        ]);

        // Cập nhật sản phẩm
        $product->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Product updated successfully',
            'data' => $product
        ], 200);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted successfully'
        ], 204);
    }
}

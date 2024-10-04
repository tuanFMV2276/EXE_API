<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['designer', 'images', 'sizes', "colors"])->get();

        // $products = DB::table('products')
        //     ->join('designers', 'products.designer_id', '=', 'designers.id')
        //     ->join('product_images', 'products.id', '=', 'product_images.product_id')
        //     ->select('products.*', 'designers.full_name as designer_name', 'product_images.image_url')
        //     ->get();

        return response()->json([
            'status' => 'success',
            'data' => $products
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'designer_id' => 'required|exists:designers,id',
        ]);

        $product = Product::create($validated);

        $product_id = $product->id;

        // $validated_size = $request->validate([
        //     'product_id' => 'required|exists:products,id',
        //     'size' => 'required|string',
        // ]);

        // $validated_image = $request->validate([
        //     'product_id' => 'required|exists:products,id',
        //     'image_url' => 'required|string',
        // ]);

        // $validated_color = $request->validate([
        //     'product_id' => 'required|exists:products,id',
        //     'color_name' => 'required|string',
        // ]);


        return response()->json([
            'product_id' => $product_id,
            'status' => 'success',
            'message' => 'Product created successfully',
            'data' => $product
        ], 201);
    }

    public function show($id)
    {

        $product = Product::with(['designer', 'images', 'sizes', 'colors'])->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $product
        ]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);


        $validated = $request->validate([
            'product_name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric',
            'designer_id' => 'sometimes|required|exists:designers,id',
        ]);


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

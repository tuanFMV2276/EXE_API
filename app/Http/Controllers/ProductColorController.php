<?php

namespace App\Http\Controllers;

use App\Models\ProductColor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productColor = ProductColor::with('product')->get();
        return response()->json($productColor, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'color_name' => 'required|string',
            'color_template' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $productColor = ProductColor::create($request->all());
        return response()->json($productColor, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $productColor = ProductColor::with('product')->find($id);

        if (!$productColor) {
            return response()->json(['message' => 'Product color not found'], 404);
        }

        return response()->json($productColor, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $productColor = ProductColor::find($id);

        if (!$productColor) {
            return response()->json(['message' => 'Product color not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'product_id' => 'sometimes|required|exists:products,id',
            'color_name' => 'required|string',
            'color_template' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $productColor->update($request->all());
        return response()->json($productColor, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $productColor = ProductColor::find($id);

        if (!$productColor) {
            return response()->json(['message' => 'Product color not found'], 404);
        }

        $productColor->delete();
        return response()->json(['message' => 'Product color deleted successfully'], 204);
    }
}

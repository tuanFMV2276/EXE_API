<?php

namespace App\Http\Controllers;

use App\Models\Designer;
use Illuminate\Http\Request;

class DesignerController extends Controller
{
    public function index()
    {
        $designers = Designer::with('products')->get();

        return response()->json([
            'status' => 'success',
            'data' => $designers
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:designers',
            'bio' => 'nullable|string',
        ]);

        $designer = Designer::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Designer created successfully',
            'data' => $designer
        ], 201);
    }

    public function show($id)
    {

        $designer = Designer::with('products')->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $designer
        ]);
    }

    public function update(Request $request, $id)
    {
        $designer = Designer::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:designers,email,' . $designer->id,
            'bio' => 'nullable|string',
        ]);

        $designer->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Designer updated successfully',
            'data' => $designer
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

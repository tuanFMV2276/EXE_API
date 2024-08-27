<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of materials along with their suppliers and designers.
     */
    public function index()
    {
        $materials = Material::with(['supplier', 'designers'])->get();

        return response()->json([
            'status' => 'success',
            'data' => $materials
        ]);
    }

    /**
     * Store a newly created material in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'supplier_id' => 'required|exists:suppliers,id',
        ]);

        $material = Material::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Material created successfully',
            'data' => $material
        ], 201);
    }

    /**
     * Display the specified material with its supplier and designers.
     */
    public function show($id)
    {
        $material = Material::with(['supplier', 'designers'])->find($id);

        if (!$material) {
            return response()->json([
                'status' => 'error',
                'message' => 'Material not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $material
        ]);
    }

    /**
     * Update the specified material in storage.
     */
    public function update(Request $request, $id)
    {
        $material = Material::find($id);

        if (!$material) {
            return response()->json([
                'status' => 'error',
                'message' => 'Material not found'
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'type' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'supplier_id' => 'sometimes|required|exists:suppliers,id',
        ]);

        $material->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Material updated successfully',
            'data' => $material
        ]);
    }

    /**
     * Remove the specified material from storage.
     */
    public function destroy($id)
    {
        $material = Material::find($id);

        if (!$material) {
            return response()->json([
                'status' => 'error',
                'message' => 'Material not found'
            ], 404);
        }

        $material->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Material deleted successfully'
        ], 200);
    }
}

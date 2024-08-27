<?php

namespace App\Http\Controllers;

use App\Models\DesignerMaterial;
use Illuminate\Http\Request;

class DesignerMaterialController extends Controller
{
    /**
     * Display a listing of designer materials with related designers and materials.
     */
    public function index()
    {
        $designerMaterials = DesignerMaterial::with(['designer', 'material'])->get();

        return response()->json([
            'status' => 'success',
            'data' => $designerMaterials
        ]);
    }

    /**
     * Store a newly created designer material relationship in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'designer_id' => 'required|exists:designers,id',
            'material_id' => 'required|exists:materials,id',
            'usage_purpose' => 'nullable|string|max:500',
        ]);

        $designerMaterial = DesignerMaterial::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Designer material relationship created successfully',
            'data' => $designerMaterial
        ], 201);
    }

    /**
     * Display the specified designer material relationship.
     */
    public function show($id)
    {
        $designerMaterial = DesignerMaterial::with(['designer', 'material'])->find($id);

        if (!$designerMaterial) {
            return response()->json([
                'status' => 'error',
                'message' => 'Designer material relationship not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $designerMaterial
        ]);
    }

    /**
     * Update the specified designer material relationship in storage.
     */
    public function update(Request $request, $id)
    {
        $designerMaterial = DesignerMaterial::find($id);

        if (!$designerMaterial) {
            return response()->json([
                'status' => 'error',
                'message' => 'Designer material relationship not found'
            ], 404);
        }

        $validated = $request->validate([
            'designer_id' => 'sometimes|required|exists:designers,id',
            'material_id' => 'sometimes|required|exists:materials,id',
            'usage_purpose' => 'nullable|string|max:500',
        ]);

        $designerMaterial->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Designer material relationship updated successfully',
            'data' => $designerMaterial
        ]);
    }

    /**
     * Remove the specified designer material relationship from storage.
     */
    public function destroy($id)
    {
        $designerMaterial = DesignerMaterial::find($id);

        if (!$designerMaterial) {
            return response()->json([
                'status' => 'error',
                'message' => 'Designer material relationship not found'
            ], 404);
        }

        $designerMaterial->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Designer material relationship deleted successfully'
        ], 200);
    }
}

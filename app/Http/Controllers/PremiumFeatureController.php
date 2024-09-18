<?php

namespace App\Http\Controllers;

use App\Models\PremiumFeature;
use Illuminate\Http\Request;

class PremiumFeatureController extends Controller
{
    public function index()
    {
        $premiumFeatures = PremiumFeature::with('subscriptions')->get();

        return response()->json([
            'status' => 'success',
            'data' => $premiumFeatures
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $premiumFeature = PremiumFeature::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Premium feature created successfully',
            'data' => $premiumFeature
        ], 201);
    }

    public function show($id)
    {
        $premiumFeature = PremiumFeature::with('subscriptions')->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $premiumFeature
        ]);
    }

    public function update(Request $request, $id)
    {
        $premiumFeature = PremiumFeature::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $premiumFeature->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Premium feature updated successfully',
            'data' => $premiumFeature
        ], 200);
    }

    public function destroy($id)
    {
        $premiumFeature = PremiumFeature::findOrFail($id);
        $premiumFeature->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Premium feature deleted successfully'
        ], 204);
    }
}

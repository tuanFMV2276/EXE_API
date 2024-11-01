<?php

namespace App\Http\Controllers;

use App\Models\PremiumFeature;
use App\Models\UserFeature;
use Illuminate\Http\Request;

class UserFeatureController extends Controller
{
    public function index()
    {
        $userFeatures = UserFeature::with(['user', 'premiumFeature'])->get();

        return response()->json([
            'status' => 'success',
            'data' => $userFeatures
        ]);
    }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'user_id' => 'required|exists:users,id',
    //         'feature_id' => 'required|exists:premium_features,id',
    //     ]);

    //     $userFeature = UserFeature::create($validated);

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'User feature created successfully',
    //         'data' => $userFeature
    //     ], 201);
    // }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'feature_id' => 'required|exists:premium_features,id',
        ]);

        $premiumFeature = PremiumFeature::findOrFail($validated['feature_id']);

        $userFeature = UserFeature::create([
            'user_id' => $validated['user_id'],
            'feature_id' => $validated['feature_id'],
            'activated_date' => now(),
            'expiry_date' => now()->addDays($premiumFeature->duration_days),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'User feature created successfully',
            'data' => $userFeature
        ], 201);
    }


    public function show($id)
    {
        $userFeature = UserFeature::with(['user', 'premiumFeature'])->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $userFeature
        ]);
    }

    public function update(Request $request, $id)
    {
        $userFeature = UserFeature::findOrFail($id);
        $validated = $request->validate([
            'status' => 'required',
        ]);

        $userFeature->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'User feature updated successfully',
            'data' => $userFeature
        ], 200);
    }

    public function destroy($id)
    {
        $userFeature = UserFeature::findOrFail($id);
        $userFeature->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User feature deleted successfully'
        ], 204);
    }
}

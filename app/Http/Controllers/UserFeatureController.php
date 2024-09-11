<?php

namespace App\Http\Controllers;

use App\Models\UserFeature;
use Illuminate\Http\Request;

class UserFeatureController extends Controller
{
    public function index()
    {
        // Lấy tất cả các tính năng của người dùng và thông tin liên quan đến người dùng và tính năng premium
        $userFeatures = UserFeature::with(['user', 'premiumFeature'])->get();

        return response()->json([
            'status' => 'success',
            'data' => $userFeatures
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'premium_feature_id' => 'required|exists:premium_features,id',
            'status' => 'required|string',
        ]);

        $userFeature = UserFeature::create($validated);

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
            'status' => 'sometimes|required|string',
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

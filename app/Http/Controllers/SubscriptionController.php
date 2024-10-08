<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::with('user')->get();

        return response()->json([
            'status' => 'success',
            'data' => $subscriptions
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'plan' => 'required|string',
            'status' => 'required|string',
            'expires_at' => 'required|date',
        ]);

        $subscription = Subscription::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Subscription created successfully',
            'data' => $subscription
        ], 201);
    }

    public function show($id)
    {
        $subscription = Subscription::with('user')->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $subscription
        ]);
    }

    public function update(Request $request, $id)
    {
        $subscription = Subscription::findOrFail($id);

        $validated = $request->validate([
            'plan' => 'sometimes|required|string',
            'status' => 'sometimes|required|string',
            'expires_at' => 'sometimes|required|date',
        ]);


        $subscription->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Subscription updated successfully',
            'data' => $subscription
        ], 200);
    }

    public function destroy($id)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Subscription deleted successfully'
        ], 204);
    }
}

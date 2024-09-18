<?php

namespace App\Http\Controllers;

use App\Models\News;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::with('user')->get();

        return Response()->json([
            'status' => 'success',
            'data' => $news
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
        ]);

        $news = News::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'News created successfully',
            'data' => $news
        ], 201);
    }

    public function show($id)
    {
        $news = News::findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $news
        ]);
    }

    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'published_at' => 'nullable|date',
        ]);

        $news->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'News updated successfully',
            'data' => $news
        ], 200);
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);
        $news->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'News deleted successfully'
        ], 204);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\News_Is_Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class NewsIsLikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $is_like = News_Is_Like::with('news', 'user')->get();
        return response()->json($is_like, 200);
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
            'user_id' => 'required|exists:users,id',
            'news_id' => 'required|exists:news,id',
            'is_like' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $is_like = News_Is_Like::create($request->all());
        return response()->json($is_like, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $is_like = News_Is_Like::with('news')->find($id);

        if (!$is_like) {
            return response()->json(['message' => 'Is_like not found'], 404);
        }

        return response()->json($is_like, 200);
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
        $is_like = News_Is_Like::find($id);

        if (!$is_like) {
            return response()->json(['message' => 'Is_like not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'is_like' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $is_like->update($request->all());
        return response()->json($is_like, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $is_like = News_Is_Like::find($id);

        if (!$is_like) {
            return response()->json(['message' => 'Is_like not found'], 404);
        }

        $is_like->delete();
        return response()->json(['message' => 'Is_like deleted successfully'], 204);
    }
}

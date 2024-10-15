<?php

namespace App\Http\Controllers;

use App\Models\Model_3d;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Model3dController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model3d = Model_3d::with('product', 'user')->get();
        return response()->json($model3d, 200);
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
            'product_id' => 'required|exists:products,id',
            'bust' => 'required|numberic',
            'waist' => 'required|numberic',
            'hips' => 'required|numberic',
            'weight' => 'required|numberic|nullable',
            'height' => 'required|numberic|nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $model3d = Model_3d::create($request->all());
        return response()->json($model3d, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model3d = Model_3d::with('product')->find($id);

        if (!$model3d) {
            return response()->json(['message' => 'Model not found'], 404);
        }

        return response()->json($model3d, 200);
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
        $model3d = Model_3d::find($id);

        if (!$model3d) {
            return response()->json(['message' => 'Model not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'bust' => 'required|numberic',
            'waist' => 'required|numberic',
            'hips' => 'required|numberic',
            'weight' => 'required|numberic|nullable',
            'height' => 'required|numberic|nullable',
            // 'stock' => 'sometimes|required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $model3d->update($request->all());
        return response()->json($model3d, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model3d = Model_3d::find($id);

        if (!$model3d) {
            return response()->json(['message' => 'Model not found'], 404);
        }

        $model3d->delete();
        return response()->json(['message' => 'Model deleted successfully'], 204);
    }
}

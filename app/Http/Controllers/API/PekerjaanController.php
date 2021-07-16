<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Task;
use Illuminate\Http\Request;

class PekerjaanController extends Controller
{

    public function index()
    {
        return Task::all();
    }

    public function show($id)
    {
        $item = Task::find($id);
        return $item;
    }

    public function store(Request $request)
    {
        $item = Task::create($request->all());

        return response()->json($item, 201);
        // return response()->json([
        //     "code" => 201,
        //     "status" => 'success',
        //     "data" => $item
        // ]);
    }

    public function update(Request $request, $id)
    {
        $item = Task::find($id);
        $item->update($request->all());

        return response()->json($item, 200);
    }

    public function delete($id)
    {
        $item = Task::find($id);
        $item->delete();

        return response()->json(null, 204);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    public function show($id)
    {
        $user = User::find($id);
        return $user;
    }

    public function store(Request $request)
    {
        $user = User::create($request->all());

        return response()->json($user, 201);
        // return response()->json([
        //     "code" => 201,
        //     "status" => 'success',
        //     "data" => $user
        // ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->update($request->all());

        return response()->json($user, 200);
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->json(null, 204);
    }
}

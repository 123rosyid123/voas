<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\API\UserRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function bulkUpdate(UserRequest $request, UserRepository $userRepository)
    {
        $query = $userRepository->bulkUpdate($request->agent_codes, $request->group_code, $request->unit_code);
        if (!$query) {
            return response()->json([
                'message' => 'failed'
            ]);
        }
        return response()->json([
            'message' => 'success'
        ]);
    }
}

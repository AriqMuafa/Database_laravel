<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    public function index()
    {
        $members = Anggota::all();
        return response()->json([
            'status' => 'success',
            'data' => $members
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string',
            'tanggal_bergabung' => 'required|date'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $member = Anggota::create($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $member
        ], 201);
    }

    public function show($id)
    {
        $member = Anggota::find($id);
        
        if (!$member) {
            return response()->json([
                'status' => 'error',
                'message' => 'Member not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $member
        ]);
    }

    public function update(Request $request, $id)
    {
        $member = Anggota::find($id);

        if (!$member) {
            return response()->json([
                'status' => 'error',
                'message' => 'Member not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'string|max:255',
            'alamat' => 'string',
            'no_telepon' => 'string',
            'tanggal_bergabung' => 'date'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $member->update($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $member
        ]);
    }

    public function destroy($id)
    {
        $member = Anggota::find($id);

        if (!$member) {
            return response()->json([
                'status' => 'error',
                'message' => 'Member not found'
            ], 404);
        }

        $member->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Member deleted successfully'
        ]);
    }
}
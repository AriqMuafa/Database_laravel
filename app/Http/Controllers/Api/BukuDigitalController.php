<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BukuDigital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BukuDigitalController extends Controller
{
    public function index()
    {
        $books = BukuDigital::all();
        return response()->json([
            'status' => 'success',
            'data' => $books
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer',
            'format_file' => 'required|string',
            'ukuran_file' => 'required|numeric',
            'file_path' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $book = BukuDigital::create($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $book
        ], 201);
    }

    public function show($id)
    {
        $book = BukuDigital::find($id);
        
        if (!$book) {
            return response()->json([
                'status' => 'error',
                'message' => 'Digital book not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $book
        ]);
    }

    public function update(Request $request, $id)
    {
        $book = BukuDigital::find($id);

        if (!$book) {
            return response()->json([
                'status' => 'error',
                'message' => 'Digital book not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'judul' => 'string|max:255',
            'pengarang' => 'string|max:255',
            'penerbit' => 'string|max:255',
            'tahun_terbit' => 'integer',
            'format_file' => 'string',
            'ukuran_file' => 'numeric',
            'file_path' => 'string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $book->update($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $book
        ]);
    }

    public function destroy($id)
    {
        $book = BukuDigital::find($id);

        if (!$book) {
            return response()->json([
                'status' => 'error',
                'message' => 'Digital book not found'
            ], 404);
        }

        $book->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Digital book deleted successfully'
        ]);
    }
}
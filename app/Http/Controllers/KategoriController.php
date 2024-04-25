<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    protected $KategoriModel;
    public function __construct()
    {
        $this->KategoriModel = new KategoriModel();
    }

    public function index()
    {
        $kategori = $this->KategoriModel->get_kategori();
        if (count($kategori) === 0) {
            return response()->json([], 204);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Data kategori berhasil didapatkan!',
                'data' => $kategori //ambil dr database
            ], 200);
        }
    }

    public function show($id)
    {
        $kategori = KategoriModel::find($id);
        if ($kategori === null) {
            return response()->json([
            'status' => 404,
            'suscess' => false,
            'messange' => 'Gagal mendapatkan data kategori! Kategori tidak ditemukan',
            'data' => $kategori
            ], 404);
           
        } else {
            return response()->json([
                'status' => 200,
                'suscess' => true,
                'message' => 'Berhasil mendapatkan data kategori!',
                'data' => $kategori
            ], 200);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori_nama' => 'required|string|max:100'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validasi pada data kategori gagal!',
                'errors' => $validator->errors()
            ], 422);
        } else {
            $kategori = $this->KategoriModel->create_kategori($validator->validated());
            return response()->json([
                'status' => 201,
                'message' => 'Data kategori berhasil dibuat!',
                'data' => $kategori
            ], 201);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'kategori_nama' => 'required|string|max:100'

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validasi pada data kategori gagal!',
                'errors' => $validator->errors()
            ], 422);
        } else {
            $kategori = $this->KategoriModel->update_kategori($validator->validated(), $id);
            return response()->json([
                'status' => 200,
                'message' => 'Data kategori berhasil diupdate!',
                'data' => $kategori
            ], 200);
        }
    }

    public function destroy($id)
    {
        $kategori = $this->KategoriModel->delete_kategori($id);
        return response()->json([
            'status' => 200,
            'message' => 'Data kategori berhasil dihapus!',
            'data' => $kategori
        ], 200);
    }
}

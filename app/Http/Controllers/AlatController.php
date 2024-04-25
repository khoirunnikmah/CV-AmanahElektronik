<?php

namespace App\Http\Controllers;

use App\Models\AlatModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AlatController extends Controller
{
    protected $AlatModel;
    public function __construct()
    {
        $this->AlatModel = new AlatModel();
    }

    public function index()
    {
        $alat = $this->AlatModel->get_alat();
        if (count($alat) === 0) {
            return response()->json([], 204);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Data alat berhasil didapatkan!',
                'data' => $alat //ambil dr database
            ], 200);
        }
    }

    public function show($id)
    {
        $alat = AlatModel::find($id);
        if ($alat === null) {
            return response()->json([
            'status' => 404,
            'suscess' => false,
            'messange' => 'Gagal mendapatkan data alat! Alat tidak ditemukan',
            'data' => $alat
            ], 404);
           
        } else {
            return response()->json([
                'status' => 200,
                'suscess' => true,
                'message' => 'Berhasil mendapatkan data alat!',
                'data' => $alat
            ], 200);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'alat_kategori_id' => 'required|exists:kategori,kategori_id',
            'alat_nama' => 'required|string|max:150',
            'alat_deskripsi' => 'required|string|max:255',
            'alat_hargaperhari' => 'required|numeric',
            'alat_stok' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validasi pada data alat gagal!',
                'errors' => $validator->errors()
            ], 422);
        } else {
            $alat = $this->AlatModel->create_alat($validator->validated());
            return response()->json([
                'status' => 201,
                'message' => 'Data alat berhasil dibuat!',
                'data' => $alat
            ], 201);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'alat_kategori_id' => 'required|exists:kategori,kategori_id',
            'alat_nama' => 'required|string|max:150',
            'alat_deskripsi' => 'required|string|max:255',
            'alat_hargaperhari' => 'required|numeric',
            'alat_stok' => 'required|numeric',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validasi pada data alat gagal!',
                'errors' => $validator->errors()
            ], 422);
        } else {
            $alat = $this->AlatModel->update_alat($validator->validated(), $id);
            return response()->json([
                'status' => 200,
                'message' => 'Data alat berhasil diupdate!',
                'data' => $alat
            ], 200);
        }
    }

    public function destroy($id)
    {
        $alat = $this->AlatModel->delete_alat($id);
        return response()->json([
            'status' => 200,
            'message' => 'Data alat berhasil dihapus!',
            'data' => $alat
        ], 200);
    }

}

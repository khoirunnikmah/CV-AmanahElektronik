<?php

namespace App\Http\Controllers;

use App\Models\PelangganModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PelangganController extends Controller
{
    protected $PelangganModel;
    public function __construct()
    {
        $this->PelangganModel = new PelangganModel();
    }

    public function index()
    {
        $pelanggan = $this->PelangganModel->get_pelanggan();
        if (count($pelanggan) === 0) {
            return response()->json([], 204);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Data pelanggan berhasil didapatkan!',
                'data' => $pelanggan //ambil dr database
            ], 200);
        }
    }

    public function show($id)
    {
        $pelanggan = PelangganModel::find($id);
        if ($pelanggan === null) {
            return response()->json([
            'status' => 404,
            'suscess' => false,
            'messange' => 'Gagal mendapatkan data pelanggan! Pelanggan tidak ditemukan',
            'data' => $pelanggan
            ], 404);
           
        } else {
            return response()->json([
                'status' => 200,
                'suscess' => true,
                'message' => 'Berhasil mendapatkan data pelanggan!',
                'data' => $pelanggan
            ], 200);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pelanggan_nama' => 'required|string|max:150',
            'pelanggan_alamat' => 'required|string|max:200',
            'pelanggan_notelp' => 'required|string|max:13',
            'pelanggan_email' => 'required|string|max:100',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Gagal menambahkan data pelanggan!',
                'errors' => $validator->errors()
            ], 422);
        } else {
            $pelanggan = $this->PelangganModel->create_pelanggan($validator->validated());
            return response()->json([
                'status' => 201,
                'message' => 'Data pelanggan berhasil dibuat!',
                'data' => $pelanggan
            ], 201);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'pelanggan_nama' => 'required|string|max:150',
            'pelanggan_alamat' => 'required|string|max:200',
            'pelanggan_notelp' => 'required|string|max:13',
            'pelanggan_email' => 'required|string|max:100',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validasi pada data pelanggan gagal!',
                'errors' => $validator->errors()
            ], 422);
        } else {
            $pelanggan = $this->PelangganModel->update_pelanggan($validator->validated(), $id);
            return response()->json([
                'status' => 200,
                'message' => 'Data pelanggan berhasil diupdate!',
                'data' => $pelanggan
            ], 200);
        }
    }

    public function destroy($id)
    {
        $pelanggan = $this->PelangganModel->delete_pelanggan($id);
        return response()->json([
            'status' => 200,
            'message' => 'Data pelanggan berhasil dihapus!',
            'data' => $pelanggan
        ], 200);
    }
}

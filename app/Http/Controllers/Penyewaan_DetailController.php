<?php

namespace App\Http\Controllers;

use App\Models\Penyewaan_DetailModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Penyewaan_DetailController extends Controller
{
    protected $Penyewaan_DetailModel;
    public function __construct()
    {
        $this->Penyewaan_DetailModel = new Penyewaan_DetailModel();
    }

    public function index()
    {
        $penyewaan_detail = $this->Penyewaan_DetailModel->get_penyewaan_detail();
        if (count($penyewaan_detail) === 0) {
            return response()->json([], 204);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Data penyewaan detail berhasil didapatkan!',
                'data' => $penyewaan_detail //ambil dr database
            ], 200);
        }
    }

    public function show($id)
    {
        $penyewaan_detail = Penyewaan_DetailModel::find($id);
        if ($penyewaan_detail === null) {
            return response()->json([
            'status' => 404,
            'suscess' => false,
            'messange' => 'Gagal mendapatkan data penyewaan detail! Penyewaan detail tidak ditemukan',
            'data' => $penyewaan_detail
            ], 404);
           
        } else {
            return response()->json([
                'status' => 200,
                'suscess' => true,
                'message' => 'Berhasil mendapatkan data penyewaan detail!',
                'data' => $penyewaan_detail
            ], 200);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'penyewaan_detail_penyewaan_id' => 'required|exists:penyewaan,penyewaan_id',
            'penyewaan_detail_alat_id' => 'required|exists:alat,alat_id',
            'penyewaan_detail_jumlah' => 'required|numeric',
            'penyewaan_detail_subharga' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validasi pada data penyewaan detail gagal!',
                'errors' => $validator->errors()
            ], 422);
        } else {
            $penyewaan_detail = $this->Penyewaan_DetailModel->create_penyewaan_detail($validator->validated());
            return response()->json([
                'status' => 201,
                'message' => 'Data penyewaan detail berhasil dibuat!',
                'data' => $penyewaan_detail
            ], 201);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'penyewaan_detail_penyewaan_id' => 'required|exists:penyewaan,penyewaan_id',
            'penyewaan_detail_alat_id' => 'required|exists:alat,alat_id',
            'penyewaan_detail_jumlah' => 'required|numeric',
            'penyewaan_detail_subharga' => 'required|numeric',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validasi pada data penyewaan detail gagal!',
                'errors' => $validator->errors()
            ], 422);
        } else {
            $penyewaan_detail = $this->Penyewaan_DetailModel->update_penyewaan_detail($validator->validated(), $id);
            return response()->json([
                'status' => 200,
                'message' => 'Data penyewaan detail berhasil diupdate!',
                'data' => $penyewaan_detail
            ], 200);
        }
    }

    public function destroy($id)
    {
        $penyewaan_detail = $this->Penyewaan_DetailModel->delete_penyewaan_detail($id);
        return response()->json([
            'status' => 200,
            'message' => 'Data penyewaan detail berhasil dihapus!',
            'data' => $penyewaan_detail
        ], 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->AdminModel = new AdminModel();
    }

    public function index()
    {
        $admin = $this->AdminModel->get_admin();
        if (count($admin) === 0) {
            return response()->json([], 204);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Data admin berhasil didapatkan!',
                'data' => $admin //ambil dr database
            ], 200);
        }
    }

    public function show($id)
    {
        $admin = AdminModel::find($id);
        if ($admin === null) {
            return response()->json([
            'status' => 404,
            'suscess' => false,
            'messange' => 'Gagal mendapatkan data admin! Admin tidak ditemukan',
            'data' => $admin
            ], 404);
           
        } else {
            return response()->json([
                'status' => 200,
                'suscess' => true,
                'message' => 'Berhasil mendapatkan data admin!',
                'data' => $admin
            ], 200);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'admin_username' => 'required|string|max:50',
            'admin_password' => 'required|string|max:255'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validasi pada data admin gagal!',
                'errors' => $validator->errors()
            ], 422);
        } else {
            $admin = $this->AdminModel->create_admin($validator->validated());
            return response()->json([
                'status' => 201,
                'message' => 'Data admin berhasil dibuat!',
                'data' => $admin
            ], 201);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'admin_username' => 'required|string|max:50',
            'admin_password' => 'required|string|max:255'

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validasi pada data admin gagal!',
                'errors' => $validator->errors()
            ], 422);
        } else {
            $admin = $this->AdminModel->update_admin($validator->validated(), $id);
            return response()->json([
                'status' => 200,
                'message' => 'Data admin berhasil diupdate!',
                'data' => $admin
            ], 200);
        }
    }

    public function destroy($id)
    {
        $admin = $this->AdminModel->delete_admin($id);
        return response()->json([
            'status' => 200,
            'message' => 'Data admin berhasil dihapus!',
            'data' => $admin
        ], 200);
    }
}

<?php
namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // List semua role
    public function index()
    {
        $roles = Role::all();

        return response()->json([
            'status'  => 200,
            'message' => 'Data role berhasil diambil',
            'data'    => $roles,
        ], 200);
    }

    // Buat role baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_role' => 'required|string|unique:roles,nama_role',
            'deskripsi' => 'nullable|string',
        ]);

        $role = Role::create($data);

        return response()->json([
            'status'  => 201,
            'message' => 'Role berhasil dibuat',
            'data'    => $role,
        ], 201);
    }

    // Update role
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $data = $request->validate([
            'nama_role' => 'sometimes|string|unique:roles,nama_role,' . $role->role_id . ',role_id',
            'deskripsi' => 'nullable|string',
        ]);

        $role->update($data);

        return response()->json([
            'status'  => 200,
            'message' => 'Role berhasil diupdate',
            'data'    => $role,
        ], 200);
    }

    // Hapus role
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json([
            'status'  => 200,
            'message' => 'Role berhasil dihapus',
        ], 200);
    }

    // Lihat detail role
    public function show($id)
    {
        $role = Role::findOrFail($id);

        return response()->json([
            'status'  => 200,
            'message' => 'Detail role berhasil diambil',
            'data'    => $role,
        ], 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * List semua user (hanya Admin)
     */
    public function index()
    {
        $users = User::select('id','name','email','role')->get();

        return response()->json([
            'status'  => 200,
            'message' => 'Data user berhasil diambil',
            'data'    => $users
        ], 200);
    }

    /**
     * Buat user baru (Admin pilih role)
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'role'     => 'required|in:Admin,Vendor,Client',
        ]);

        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        return response()->json([
            'status'  => 201,
            'message' => 'User berhasil dibuat',
            'data'    => $user
        ], 201);
    }

    /**
     * Update data user + role
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name'     => 'sometimes|string|max:255',
            'email'    => 'sometimes|email|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:6',
            'role'     => 'sometimes|in:Admin,Vendor,Client',
        ]);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return response()->json([
            'status'  => 200,
            'message' => 'User berhasil diupdate',
            'data'    => $user
        ], 200);
    }

    /**
     * Hapus user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'status'  => 200,
            'message' => 'User berhasil dihapus'
        ], 200);
    }
}

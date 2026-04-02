<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prioritas;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PrioritasController extends Controller
{
    // Ambil semua data prioritas
    public function index()
    {
        $prioritas = Prioritas::orderBy('prioritas_id', 'desc')->get();
        return view('admin.prioritas.index', compact('prioritas'));
    }

    // Form tambah prioritas
    public function create()
    {
        return view('admin.prioritas.create');
    }

    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'nama_prioritas' => 'required|string|max:50|unique:priorities,nama_prioritas',
    ], [
        'nama_prioritas.required' => 'Nama prioritas wajib diisi',
        'nama_prioritas.unique'   => 'Nama prioritas sudah ada',
        'nama_prioritas.max'      => 'Nama prioritas maksimal 50 karakter',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    try {
        // ✅ Hapus baris setval ini (tidak diperlukan di MySQL)
        // DB::statement("SELECT setval(...) ...");

        Prioritas::create([
            'nama_prioritas' => $request->nama_prioritas,
        ]);

        return redirect()->route('prioritas.index')  // atau admin.prioritas.index kalau sudah di-fix
            ->with('success', 'Prioritas baru berhasil ditambahkan');

    } catch (\Exception $e) {
        // Untuk debugging, sementara tampilkan error asli
        return redirect()->back()
            ->withInput()
            ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

    // Detail prioritas
    public function show($id)
    {
        $prioritas = Prioritas::findOrFail($id);
        return view('admin.prioritas.show', compact('prioritas'));
    }

    // Form edit prioritas
    public function edit($id)
    {
        $prioritas = Prioritas::findOrFail($id);
        return view('admin.prioritas.edit', compact('prioritas'));
    }

    // Update prioritas
    public function update(Request $request, $id)
    {
        $prioritas = Prioritas::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_prioritas' => 'required|string|max:50|unique:priorities,nama_prioritas,' . $id . ',prioritas_id',
        ], [
            'nama_prioritas.required' => 'Nama prioritas wajib diisi',
            'nama_prioritas.unique' => 'Nama prioritas sudah ada',
            'nama_prioritas.max' => 'Nama prioritas maksimal 50 karakter',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $prioritas->update([
                'nama_prioritas' => $request->nama_prioritas,
            ]);

            return redirect()->route('prioritas.index')
                ->with('success', 'Prioritas berhasil diperbarui');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }

    // Hapus prioritas
    public function destroy($id)
    {
        try {
            $prioritas = Prioritas::findOrFail($id);
            $prioritas->delete();

            return redirect()->route('prioritas.index')
                ->with('success', 'Prioritas berhasil dihapus');

        } catch (\Exception $e) {
            return redirect()->route('prioritas.index')
                ->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
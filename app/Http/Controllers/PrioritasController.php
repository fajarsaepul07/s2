<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prioritas;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;   // ← Tambahkan ini

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

    // Simpan prioritas baru
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_prioritas' => [
                'required',
                'string',
                'max:50',
                Rule::unique('priorities', 'nama_prioritas')
            ],
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
            Prioritas::create([
                'nama_prioritas' => $request->nama_prioritas,
            ]);

            return redirect()->route('admin.prioritas.index')
                ->with('success', 'Prioritas baru berhasil ditambahkan');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage() . ' | Line: ' . $e->getLine());
        }
    }

    // Detail prioritas (opsional)
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
            'nama_prioritas' => [
                'required',
                'string',
                'max:50',
                Rule::unique('priorities', 'nama_prioritas')
                    ->ignore($id, 'prioritas_id')
            ],
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
            $prioritas->update([
                'nama_prioritas' => $request->nama_prioritas,
            ]);

            return redirect()->route('admin.prioritas.index')
                ->with('success', 'Prioritas berhasil diperbarui');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage() . ' | Line: ' . $e->getLine());
        }
    }

    // Hapus prioritas
    public function destroy($id)
    {
        try {
            $prioritas = Prioritas::findOrFail($id);
            $prioritas->delete();

            return redirect()->route('admin.prioritas.index')
                ->with('success', 'Prioritas berhasil dihapus');

        } catch (\Exception $e) {
            return redirect()->route('admin.prioritas.index')
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
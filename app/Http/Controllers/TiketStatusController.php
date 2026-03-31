<?php

namespace App\Http\Controllers;

use App\Models\TiketStatus;
use Illuminate\Http\Request;

class TiketStatusController extends Controller
{

public function index()
{
    $statuses = TiketStatus::orderBy('status_id', 'desc')->get();
    return view('admin.status.index', compact('statuses'));
}

public function create()
{
    return view('admin.status.create');
}

public function store(Request $request)
{
    $validated = $request->validate(['nama_status' => 'required|string|max:255']);
    TiketStatus::create($validated);

    return redirect()->route('admin.status.index')
                     ->with('success', 'Status tiket berhasil dibuat');
}

public function edit($id)
{
    $status = TiketStatus::findOrFail($id);
    return view('admin.status.edit', compact('status'));
}

public function update(Request $request, $id)
{
    $status = TiketStatus::findOrFail($id);
    $validated = $request->validate(['nama_status' => 'required|string|max:255']);
    $status->update($validated);

    return redirect()->route('admin.status.index')
                     ->with('success', 'Status tiket berhasil diperbarui');
}

public function destroy($id)
{
    $status = TiketStatus::findOrFail($id);
    $status->delete();

    return redirect()->route('admin.status.index')
                     ->with('success', 'Status tiket berhasil dihapus');
}
}

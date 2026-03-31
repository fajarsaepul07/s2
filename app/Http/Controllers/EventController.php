<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->get();
        
        return view('admin.event.index', compact('events'));
    }

    public function create()
    {
        return view('admin.event.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_event'      => 'required|string|max:255',
            'lokasi'          => 'required|string',
            'area'            => 'required|string',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        Event::create($validated);

        return redirect()->route('event.index')
            ->with('success', 'Event berhasil dibuat');
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
        
        return view('admin.event.show', compact('event'));
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        
        return view('admin.event.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $validated = $request->validate([
            'nama_event'      => 'required|string|max:255',
            'lokasi'          => 'required|string',
            'area'            => 'required|string',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $event->update($validated);

        return redirect()->route('event.index')
            ->with('success', 'Event berhasil diperbarui');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->route('event.index')
            ->with('success', 'Event berhasil dihapus');
    }
}
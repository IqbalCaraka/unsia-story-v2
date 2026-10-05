<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->paginate(15);

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_event' => 'required|string|max:255',
            'tanggal_event' => 'required|date',
            'jam_event' => 'required',
            'link_zoom' => 'nullable|url|max:500',
            'link_materi' => 'nullable|url|max:500',
            'link_sertif' => 'nullable|url|max:500',
            'status' => 'required|in:upcoming,ongoing,completed',
        ]);

        Event::create($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil dibuat.');
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'nama_event' => 'required|string|max:255',
            'tanggal_event' => 'required|date',
            'jam_event' => 'required',
            'link_zoom' => 'nullable|url|max:500',
            'link_materi' => 'nullable|url|max:500',
            'link_sertif' => 'nullable|url|max:500',
            'status' => 'required|in:upcoming,ongoing,completed',
        ]);

        $event->update($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil dihapus.');
    }

    public function registrations(string $id)
    {
        $event = Event::with('registrations')->findOrFail($id);

        return view('admin.events.registrations', compact('event'));
    }

    public function sendZoom(string $id)
    {
        $event = Event::findOrFail($id);

        // TODO: Implement sending zoom links to registered participants

        return redirect()->back()
            ->with('success', 'Link Zoom akan dikirim ke peserta.');
    }

    public function sendSertif(string $id)
    {
        $event = Event::findOrFail($id);

        // TODO: Implement sending certificates to attended participants

        return redirect()->back()
            ->with('success', 'Sertifikat akan dikirim ke peserta.');
    }
}

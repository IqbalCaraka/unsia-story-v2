<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CallbackRequest;
use Illuminate\Http\Request;

class CallbackRequestController extends Controller
{
    public function index()
    {
        $callbacks = CallbackRequest::latest()->paginate(15);

        return view('admin.callback.index', compact('callbacks'));
    }

    public function markContacted(string $id)
    {
        $callback = CallbackRequest::findOrFail($id);
        $callback->update(['status' => 'contacted']);

        return redirect()->route('admin.callback.index')
            ->with('success', 'Status berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $callback = CallbackRequest::findOrFail($id);
        $callback->delete();

        return redirect()->route('admin.callback.index')
            ->with('success', 'Permintaan callback berhasil dihapus.');
    }
}

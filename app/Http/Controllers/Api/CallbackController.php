<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CallbackRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class CallbackController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $key = 'callback-request:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 3)) {
            return response()->json([
                'success' => false,
                'message' => 'Terlalu banyak permintaan. Silakan coba lagi nanti.',
            ], 429);
        }

        RateLimiter::hit($key, 60);

        $validated = $request->validate([
            'nama' => 'required|max:100',
            'kontak' => 'required|max:100',
            'tanggal_hubungi' => 'required|date',
            'waktu_hubungi' => 'required|string',
        ]);

        CallbackRequest::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Permintaan callback berhasil dikirim.',
        ], 201);
    }
}

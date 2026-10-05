<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MataKuliah;
use App\Services\KonversiMatcher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    public function search(Request $request, KonversiMatcher $matcher): JsonResponse
    {
        // Semua mata kuliah (dipakai untuk pencarian lokal di browser).
        if ($request->has('all')) {
            $all = MataKuliah::query()
                ->berbobot()
                ->orderBy('nama_mk')
                ->get(['nama_mk as nama', 'prodi', 'sks', 'keywords']);

            return response()->json($all);
        }

        // Smart match ketika pencarian lokal tidak menemukan apa pun.
        $fuzzy = trim((string) $request->query('fuzzy', ''));
        if ($fuzzy !== '' && mb_strlen($fuzzy) >= 3) {
            return response()->json($matcher->fuzzySearch($fuzzy));
        }

        // Pencarian kata kunci biasa.
        $q = trim((string) $request->query('q', ''));
        if ($q !== '' && mb_strlen($q) >= 3) {
            $rows = MataKuliah::query()
                ->berbobot()
                ->where(function ($query) use ($q) {
                    $query->where('nama_mk', 'like', "%{$q}%")
                        ->orWhere('keywords', 'like', "%{$q}%");
                })
                ->orderBy('nama_mk')
                ->limit(15)
                ->get(['nama_mk as nama', 'prodi', 'sks', 'keywords']);

            return response()->json($rows);
        }

        return response()->json([]);
    }
}

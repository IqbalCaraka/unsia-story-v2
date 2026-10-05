<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahunAjar;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TahunAjarController extends Controller
{
    public function index()
    {
        $tahunAjarList = TahunAjar::withCount(['users', 'pengajuanCashback'])
            ->orderByDesc('tahun_ajar')
            ->orderBy('ganjil_genap')
            ->paginate(20);

        return view('admin.tahun-ajar.index', compact('tahunAjarList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules(), $this->messages(), $this->attributes());

        TahunAjar::create($validated);

        return redirect()->route('admin.tahun-ajar.index')
            ->with('success', 'Tahun ajar berhasil ditambahkan.');
    }

    public function update(Request $request, TahunAjar $tahunAjar)
    {
        // Bag terpisah per baris supaya error muncul di modal yang benar,
        // bukan di form "tambah" yang ada di halaman yang sama.
        $validated = $request->validateWithBag(
            "tahunAjar{$tahunAjar->id}",
            $this->rules($tahunAjar),
            $this->messages(),
            $this->attributes()
        );

        $tahunAjar->update($validated);

        return redirect()->route('admin.tahun-ajar.index')
            ->with('success', 'Tahun ajar berhasil diperbarui.');
    }

    public function destroy(TahunAjar $tahunAjar)
    {
        // FK-nya nullOnDelete, jadi mahasiswa tidak ikut terhapus tapi tahun ajarnya jadi kosong.
        if ($jumlah = $tahunAjar->users()->count()) {
            return back()->with('error',
                "Tahun ajar ini masih dipakai {$jumlah} pengguna. Pindahkan dulu pengguna tersebut sebelum menghapus.");
        }

        // FK cashback sengaja restrictOnDelete: riwayat pembayaran tidak boleh kehilangan periodenya.
        if ($jumlah = $tahunAjar->pengajuanCashback()->count()) {
            return back()->with('error',
                "Tahun ajar ini punya {$jumlah} pengajuan cashback dan tidak bisa dihapus.");
        }

        $tahunAjar->delete();

        return redirect()->route('admin.tahun-ajar.index')
            ->with('success', 'Tahun ajar berhasil dihapus.');
    }

    protected function rules(?TahunAjar $tahunAjar = null): array
    {
        return [
            'tahun_ajar' => [
                'required', 'string', 'max:20',
                'regex:/^\d{4}\/\d{4}$/',
                Rule::unique('tahun_ajar')
                    ->where(fn ($q) => $q->where('ganjil_genap', request('ganjil_genap')))
                    ->ignore($tahunAjar),
            ],
            'ganjil_genap' => ['required', Rule::in(['ganjil', 'genap'])],
            // 0 berarti periode ini tidak membuka cashback.
            'nominal_cashback' => ['required', 'numeric', 'min:0', 'max:99999999'],
        ];
    }

    protected function messages(): array
    {
        return [
            'tahun_ajar.regex' => 'Format tahun ajar harus seperti 2025/2026.',
            'tahun_ajar.unique' => 'Kombinasi tahun ajar dan semester ini sudah ada.',
        ];
    }

    protected function attributes(): array
    {
        return [
            'tahun_ajar' => 'tahun ajar',
            'ganjil_genap' => 'semester',
        ];
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Memindahkan data situs lama (unsia-story v1, PHP biasa) ke skema v2.
 *
 * Sumbernya dibaca lewat koneksi "v1" yang dikonfigurasi di config/database.php
 * dan diarahkan oleh variabel DB_V1_* di .env.
 */
class MigrasiDariV1 extends Command
{
    protected $signature = 'migrasi:v1
                            {--segar : Kosongkan dulu tabel tujuan sebelum menyalin}
                            {--uji : Hanya hitung, tidak menulis apa pun}';

    protected $description = 'Pindahkan data dari database situs lama (v1) ke tabel v2';

    protected bool $uji = false;

    public function handle(): int
    {
        $this->uji = (bool) $this->option('uji');

        try {
            DB::connection('v1')->getPdo();
        } catch (\Throwable $e) {
            $this->error('Tidak bisa terhubung ke database v1. Periksa DB_V1_* di .env.');
            $this->line('  ' . $e->getMessage());

            return self::FAILURE;
        }

        if ($this->uji) {
            $this->warn('Mode uji: tidak ada data yang ditulis.');
        }

        if ($this->option('segar') && ! $this->uji) {
            $this->kosongkan();
        }

        $hasil = [];
        $hasil[] = ['blog_posts', $this->blogPosts()];
        $hasil[] = ['callback_requests', $this->callbackRequests()];
        $hasil[] = ['rpl_leads', $this->leads()];
        $hasil[] = ['events', $this->events()];
        $hasil[] = ['event_registrations', $this->eventRegistrations()];
        $hasil[] = ['users (dari admins)', $this->admins()];

        $this->newLine();
        $this->table(['Tabel tujuan', 'Baris dipindahkan'], $hasil);

        return self::SUCCESS;
    }

    protected function kosongkan(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        foreach (['event_registrations', 'events', 'blog_posts', 'callback_requests', 'rpl_leads'] as $t) {
            DB::table($t)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        $this->warn('Tabel tujuan dikosongkan.');
    }

    /** Kolomnya identik, id dipertahankan agar URL lama tetap cocok. */
    protected function blogPosts(): int
    {
        return $this->salin('blog_posts', 'blog_posts', fn ($r) => [
            'id' => $r->id,
            'judul' => $r->judul,
            'slug' => $r->slug,
            'thumbnail' => $r->thumbnail ?: null,
            'konten' => $r->konten,
            'kategori' => $r->kategori,
            'status' => $r->status,
            'created_at' => $r->created_at,
            'updated_at' => $r->updated_at ?? $r->created_at,
        ]);
    }

    protected function callbackRequests(): int
    {
        return $this->salin('callback_requests', 'callback_requests', fn ($r) => [
            'id' => $r->id,
            'nama' => $r->nama,
            'kontak' => $r->kontak,
            'tanggal_hubungi' => $r->tanggal_hubungi,
            'waktu_hubungi' => $r->waktu_hubungi,
            'status' => $r->status,
            'created_at' => $r->created_at,
            'updated_at' => $r->created_at,
        ]);
    }

    protected function leads(): int
    {
        return $this->salin('leads', 'rpl_leads', fn ($r) => [
            'id' => $r->id,
            'nama' => $r->nama,
            'email' => $r->email,
            'whatsapp' => $r->whatsapp,
            'sumber' => $r->sumber,
            'prodi_cocok' => $r->prodi_cocok,
            'jenis_rpl' => $r->jenis_rpl,
            'input_mk' => $r->input_mk,
            'created_at' => $r->created_at,
            'updated_at' => $r->created_at,
        ]);
    }

    protected function events(): int
    {
        return $this->salin('events', 'events', fn ($r) => [
            'id' => $r->id,
            'nama_event' => $r->judul,
            'deskripsi' => $r->deskripsi,
            'tanggal_event' => $r->tanggal_event,
            'jam_event' => $this->keJam($r->waktu_event),
            'lokasi' => $r->lokasi,
            'poster' => $r->poster ?: null,
            'kuota' => (int) $r->kuota,
            'link_zoom' => $r->link_zoom ?: null,
            'link_materi' => null,
            'link_sertif' => $r->link_sertif,
            'status' => match ($r->status) {
                'closed' => 'completed',
                default => 'upcoming',   // 'active' dan 'draft'
            },
            'presensi_status' => $r->presensi_status,
            'created_at' => $r->created_at,
            'updated_at' => $r->created_at,
        ]);
    }

    protected function eventRegistrations(): int
    {
        return $this->salin('event_registrations', 'event_registrations', fn ($r) => [
            'id' => $r->id,
            'event_id' => $r->event_id,
            'nama' => $r->nama_lengkap,
            'email' => $r->email,
            'no_wa' => $r->whatsapp,
            'asal_kota' => null,              // tidak ada di v1
            'follow_verified' => $r->follow_verified,
            'zoom_sent' => $r->zoom_sent,
            'reminder_sent' => $r->reminder_sent,
            'attended' => $r->status === 'attended' ? 'yes' : 'no',
            'sertif_sent' => $r->sertif_sent,
            'pekerjaan' => $r->pekerjaan,
            'sumber_info' => $r->sumber_info ?: null,
            'info_asal' => $r->info_asal,
            'presensi_time' => $r->presensi_time,
            'sosmed_sdp_platform' => $r->sosmed_sdp_platform ?: null,
            'sosmed_sdp_username' => $r->sosmed_sdp_username ?: null,
            'sosmed_us_platform' => $r->sosmed_us_platform ?: null,
            'sosmed_us_username' => $r->sosmed_us_username ?: null,
            'created_at' => $r->created_at,
            'updated_at' => $r->created_at,
        ]);
    }

    /**
     * Admin v1 login pakai username tanpa email, sedangkan v2 pakai email.
     * Email sementara dibentuk dari username; wajib diganti setelah migrasi.
     * Hash bcrypt v1 kompatibel dengan Laravel, jadi password lama tetap berlaku.
     */
    protected function admins(): int
    {
        $jumlah = 0;

        foreach (DB::connection('v1')->table('admins')->get() as $r) {
            $email = $r->username . '@unsia-lama.local';

            if (DB::table('users')->where('email', $email)->exists()) {
                continue;
            }

            $jumlah++;

            if ($this->uji) {
                continue;
            }

            $hash = $r->password_hash;

            DB::table('users')->insert([
                'name' => $r->username,
                'nama' => $r->username,
                'email' => $email,
                // Kalau hash lama bukan bcrypt, pakai password acak supaya akun tidak bisa ditebak.
                'password' => str_starts_with($hash, '$2y$') ? $hash : Hash::make(bin2hex(random_bytes(16))),
                'role' => 'admin',
                'created_at' => $r->created_at,
                'updated_at' => $r->created_at,
            ]);
        }

        return $jumlah;
    }

    /**
     * Salin tabel sumber ke tujuan, lewati baris yang id-nya sudah ada.
     */
    protected function salin(string $dari, string $ke, callable $peta): int
    {
        $jumlah = 0;
        $adaId = DB::table($ke)->pluck('id')->flip();

        foreach (DB::connection('v1')->table($dari)->orderBy('id')->cursor() as $r) {
            if ($adaId->has($r->id)) {
                continue;
            }

            $jumlah++;

            if (! $this->uji) {
                DB::table($ke)->insert($peta($r));
            }
        }

        return $jumlah;
    }

    /**
     * v1 menyimpan waktu sebagai teks bebas ("09.00 WIB", "19:30 - 21:00"),
     * sedangkan v2 memakai kolom TIME. Ambil jam pertama yang ditemukan.
     */
    protected function keJam(?string $teks): string
    {
        if ($teks && preg_match('/(\d{1,2})[.:](\d{2})/', $teks, $m)) {
            return sprintf('%02d:%02d:00', min((int) $m[1], 23), min((int) $m[2], 59));
        }

        return '00:00:00';
    }
}

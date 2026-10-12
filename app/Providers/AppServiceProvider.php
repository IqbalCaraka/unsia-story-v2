<?php

namespace App\Providers;

use App\Models\PengajuanCashback;
use App\Models\PengajuanUbahNim;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Badge jumlah pengajuan yang menunggu tindakan admin, di sidebar.
        // Mahasiswa memakai layout yang sama tapi tidak melihat badge ini,
        // jadi query-nya dilewati supaya tidak membebani tiap halaman mereka.
        View::composer('layouts.admin', function ($view) {
            if (! auth()->check() || ! auth()->user()->isPengelola()) {
                return;
            }

            $view->with([
                'jumlahPengajuanNim' => PengajuanUbahNim::menunggu()->count(),
                // Termasuk yang sudah diverifikasi tapi belum ditransfer.
                'jumlahCashback' => PengajuanCashback::whereIn('status', ['menunggu', 'diverifikasi'])->count(),
            ]);
        });
    }
}

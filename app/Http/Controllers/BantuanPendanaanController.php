<?php

namespace App\Http\Controllers;

class BantuanPendanaanController extends Controller
{
    /**
     * Halaman informasi program bantuan pendanaan.
     *
     * Formulir pengajuan publik sudah dihapus; pengajuan akan dipindahkan
     * ke area mahasiswa yang login. Pengelolaan data yang sudah masuk tetap
     * di Admin\PengajuanBantuanController.
     */
    public function index()
    {
        return view('pages.bantuan-pendanaan');
    }
}

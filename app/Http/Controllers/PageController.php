<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class PageController extends Controller
{
    public function index()
    {
        return view('pages.index');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function faq()
    {
        return view('pages.faq');
    }

    public function prodi(string $slug)
    {
        $viewName = 'pages.prodi.' . $slug;

        if (!View::exists($viewName)) {
            abort(404);
        }

        return view($viewName);
    }
}

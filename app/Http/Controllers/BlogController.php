<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::published()->latest();

        if ($request->has('kategori') && $request->kategori) {
            $query->kategori($request->kategori);
        }

        $posts = $query->paginate(9);

        return view('blog.index', compact('posts'));
    }

    public function show(string $slug)
    {
        $post = BlogPost::published()->where('slug', $slug)->firstOrFail();

        return view('blog.show', compact('post'));
    }
}

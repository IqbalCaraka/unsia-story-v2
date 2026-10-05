<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BlogPostController extends Controller
{
    public function index()
    {
        $posts = BlogPost::latest()->paginate(15);

        return view('admin.blog.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.blog.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'kategori' => 'required|in:blog,berita',
            'status' => 'required|in:draft,published',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,gif,webp|max:5120',
        ]);

        $validated['slug'] = BlogPost::generateSlug($validated['judul']);

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/blog'), $filename);
            $validated['thumbnail'] = 'images/blog/' . $filename;
        }

        BlogPost::create($validated);

        return redirect()->route('admin.blog.index')
            ->with('success', 'Blog post berhasil dibuat.');
    }

    public function edit(BlogPost $blogPost)
    {
        return view('admin.blog.edit', compact('blogPost'));
    }

    public function update(Request $request, BlogPost $blogPost)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'kategori' => 'required|in:blog,berita',
            'status' => 'required|in:draft,published',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,gif,webp|max:5120',
        ]);

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($blogPost->thumbnail && File::exists(public_path($blogPost->thumbnail))) {
                File::delete(public_path($blogPost->thumbnail));
            }

            $file = $request->file('thumbnail');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/blog'), $filename);
            $validated['thumbnail'] = 'images/blog/' . $filename;
        }

        $blogPost->update($validated);

        return redirect()->route('admin.blog.index')
            ->with('success', 'Blog post berhasil diperbarui.');
    }

    public function destroy(BlogPost $blogPost)
    {
        if ($blogPost->thumbnail && File::exists(public_path($blogPost->thumbnail))) {
            File::delete(public_path($blogPost->thumbnail));
        }

        $blogPost->delete();

        return redirect()->route('admin.blog.index')
            ->with('success', 'Blog post berhasil dihapus.');
    }
}

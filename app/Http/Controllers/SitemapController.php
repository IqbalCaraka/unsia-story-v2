<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $blogPosts = BlogPost::published()->latest()->get();

        $staticPages = [
            ['url' => url('/'), 'priority' => '1.0'],
            ['url' => url('/about'), 'priority' => '0.8'],
            ['url' => url('/faq'), 'priority' => '0.7'],
            ['url' => url('/konversi-mata-kuliah'), 'priority' => '0.7'],
            ['url' => url('/bantuan-pendanaan'), 'priority' => '0.8'],
            ['url' => url('/bantuan-pendanaan/ajukan'), 'priority' => '0.7'],
            ['url' => url('/blog'), 'priority' => '0.8'],
            ['url' => url('/prodi/sistem-informasi'), 'priority' => '0.8'],
            ['url' => url('/prodi/informatika'), 'priority' => '0.8'],
            ['url' => url('/prodi/manajemen'), 'priority' => '0.8'],
            ['url' => url('/prodi/akuntansi'), 'priority' => '0.8'],
            ['url' => url('/prodi/komunikasi'), 'priority' => '0.8'],
            ['url' => url('/prodi/teknologi-informasi'), 'priority' => '0.8'],
        ];

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($staticPages as $page) {
            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars($page['url']) . '</loc>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>' . $page['priority'] . '</priority>';
            $xml .= '</url>';
        }

        foreach ($blogPosts as $post) {
            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars(url('/blog/' . $post->slug)) . '</loc>';
            $xml .= '<lastmod>' . $post->updated_at->toW3cString() . '</lastmod>';
            $xml .= '<changefreq>monthly</changefreq>';
            $xml .= '<priority>0.6</priority>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'text/xml');
    }
}

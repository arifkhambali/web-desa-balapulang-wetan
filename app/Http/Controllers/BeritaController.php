<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $kategori = $request->get('kategori');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $sort = $request->get('sort', 'newest');

        $beritas = Berita::with('kategoriBerita')
            ->published()
            ->search($search)
            ->byKategori($kategori)
            ->byDateRange($startDate, $endDate)
            ->sortBy($sort)
            ->paginate(12)
            ->withQueryString();

        // Get available categories from database (distinct values)
        $categories = Berita::where('status', 'published')
            ->distinct()
            ->pluck('kategori')
            ->filter()
            ->sort()
            ->values();

        // AJAX request - return only the berita list partial
        if ($request->ajax()) {
            return view('partials.berita-list', compact('beritas'))->render();
        }
        
        // Data for sidebar
        $kategoriList = KategoriBerita::withCount(['beritas' => function ($query) {
            $query->where('status', 'published')
                  ->where('published_at', '<=', now());
        }])
        ->having('beritas_count', '>', 0)
        ->orderBy('beritas_count', 'desc')
        ->get();

        $beritaTerpopuler = Berita::where('status', 'published')
            ->where('published_at', '<=', now())
            ->orderBy('views', 'desc')
            ->limit(5)
            ->get();

        return view('berita', compact('beritas', 'kategoriList', 'beritaTerpopuler', 'categories', 'search', 'kategori', 'startDate', 'endDate', 'sort'));
    }

    public function show($slug)
    {
        $berita = Berita::with('kategoriBerita')
            ->where('slug', $slug)
            ->where('status', 'published')
            ->where('published_at', '<=', now())
            ->firstOrFail();

        // Increment views
        $berita->increment('views');

        // Related news (same category, exclude current)
        $beritaTerkait = Berita::where('status', 'published')
            ->where('published_at', '<=', now())
            ->where('kategori_berita_id', $berita->kategori_berita_id)
            ->where('id', '!=', $berita->id)
            ->latest('published_at')
            ->limit(5)
            ->get();

        // Popular news
        $beritaTerpopuler = Berita::where('status', 'published')
            ->where('published_at', '<=', now())
            ->where('id', '!=', $berita->id)
            ->orderBy('views', 'desc')
            ->limit(5)
            ->get();

        // Categories with count
        $kategoriList = KategoriBerita::withCount(['beritas' => function ($query) {
            $query->where('status', 'published')
                  ->where('published_at', '<=', now());
        }])
        ->having('beritas_count', '>', 0)
        ->orderBy('beritas_count', 'desc')
        ->get();

        return view('berita-detail', compact('berita', 'beritaTerkait', 'beritaTerpopuler', 'kategoriList'));
    }
}

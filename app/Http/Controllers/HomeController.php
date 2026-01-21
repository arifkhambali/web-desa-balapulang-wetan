<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\Galeri;
use App\Models\AparaturDesa;
use App\Models\ProfilDesa;

use App\Models\JenisSurat;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $identitasDesa = \App\Models\IdentitasDesa::first() ?? new \App\Models\IdentitasDesa([
            'nama_desa' => 'Desa Tundagan',
            'alamat' => 'Alamat Desa Belum Diisi',
            'email' => 'admin@desa.id',
            'telepon' => '-',
        ]);

        $featuredProducts = Umkm::with('kategoriUmkm')
            ->where('aktif', true)
            ->where('featured', true)
            ->latest()
            ->limit(5)
            ->get();

        $latestNews = \Firefly\FilamentBlog\Models\Post::where('status', 'published')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->limit(5)
            ->get();

        $galleries = Galeri::latest()->limit(8)->get();

        $aparaturDesa = Cache::remember('home_aparatur', 86400, function () {
            return AparaturDesa::where('aktif', true)
                ->orderBy('urutan', 'asc')
                ->limit(6)
                ->get();
        });

        $profilDesa = Cache::remember('home_profil', 86400, function () {
            return ProfilDesa::where('aktif', true)
                ->orderBy('urutan', 'asc')
                ->get();
        });

        $stats = Cache::remember('home_stats', 3600, function () {
            return [
                'totalPenduduk' => \App\Models\Penduduk::count(),
                'totalLakiLaki' => \App\Models\Penduduk::where('jenis_kelamin', 'Laki-laki')->count(),
                'totalPerempuan' => \App\Models\Penduduk::where('jenis_kelamin', 'Perempuan')->count(),
                'totalKepalaKeluarga' => \App\Models\Penduduk::where('status_keluarga', 'Kepala Keluarga')->count(),
            ];
        });

        $totalPenduduk = $stats['totalPenduduk'];
        $totalLakiLaki = $stats['totalLakiLaki'];
        $totalPerempuan = $stats['totalPerempuan'];
        $totalKepalaKeluarga = $stats['totalKepalaKeluarga'];

        // Fetch JenisSurat for Home (limit 8)
        $jenisSurat = JenisSurat::where('aktif', true)->take(8)->get();

        // Anggaran Desa Logic
        $tahunAnggaran = \App\Models\AnggaranDesa::max('tahun');
        $anggaranPendapatan = 0;
        $anggaranBelanja = 0;
        $anggaranPembiayaan = 0;

        if ($tahunAnggaran) {
            $anggaran = \App\Models\AnggaranDesa::where('tahun', $tahunAnggaran)->get();
            $anggaranPendapatan = $anggaran->where('jenis', 'pendapatan')->sum('nominal');
            $anggaranBelanja = $anggaran->where('jenis', 'belanja')->sum('nominal');
            $anggaranPembiayaan = $anggaran->where('jenis', 'pembiayaan')->sum('nominal');
        }

        return view('home', compact('identitasDesa', 'featuredProducts', 'latestNews', 'galleries', 'aparaturDesa', 'profilDesa', 'totalPenduduk', 'totalLakiLaki', 'totalPerempuan', 'totalKepalaKeluarga', 'jenisSurat', 'tahunAnggaran', 'anggaranPendapatan', 'anggaranBelanja', 'anggaranPembiayaan'));
    }

    public function layanan()
    {
        $identitasDesa = \App\Models\IdentitasDesa::first() ?? new \App\Models\IdentitasDesa([
            'nama_desa' => 'Desa Tundagan',
            'alamat' => 'Alamat Desa Belum Diisi',
            'email' => 'admin@desa.id',
            'telepon' => '-',
        ]);
        // Fetch all active JenisSurat for Layanan page
        $jenisSurat = JenisSurat::where('aktif', true)->get();

        return view('layanan', compact('identitasDesa', 'jenisSurat'));
    }


    public function umkm()
    {
        $identitasDesa = \App\Models\IdentitasDesa::first() ?? new \App\Models\IdentitasDesa([
            'nama_desa' => 'Desa Tundagan',
            'alamat' => 'Alamat Desa Belum Diisi',
            'email' => 'admin@desa.id',
            'telepon' => '-',
        ]);

        $search = request('search');
        $kategori = request('kategori');
        $minPrice = request('min_price');
        $maxPrice = request('max_price');
        $sort = request('sort', 'newest');

        $products = Umkm::with('kategoriUmkm')
            ->where('aktif', true)
            ->search($search)
            ->byKategori($kategori)
            ->byPriceRange($minPrice, $maxPrice)
            ->sortBy($sort)
            ->paginate(20)
            ->withQueryString();

        // Get available categories from database (distinct values)
        $categories = Umkm::where('aktif', true)
            ->distinct()
            ->pluck('kategori')
            ->filter()
            ->sort()
            ->values();

        // AJAX request - return only products
        if (request()->ajax()) {
            return view('partials.umkm-list', compact('products'))->render();
        }

        return view('umkm', compact('identitasDesa', 'products', 'categories', 'search', 'kategori', 'minPrice', 'maxPrice', 'sort'));
    }

    public function umkmDetail($slug)
    {
        $product = Umkm::where('slug', $slug)
            ->where('aktif', true)
            ->with('kategoriUmkm')
            ->firstOrFail();

        // Increment views count
        $product->increment('views');

        $relatedProducts = Umkm::with('kategoriUmkm')
            ->where('aktif', true)
            ->where('kategori_umkm_id', $product->kategori_umkm_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        return view('umkm-detail', compact('product', 'relatedProducts'));
    }

    public function pemerintahan()
    {
        $aparaturDesa = AparaturDesa::where('aktif', true)
            ->orderBy('urutan', 'asc')
            ->get();

        return view('pemerintahan', compact('aparaturDesa'));
    }

    public function profil()
    {
        // Get Kepala Desa for sambutan
        $kepalaDesa = AparaturDesa::where('aktif', true)
            ->where('jabatan', 'Kepala Desa')
            ->first();

        // Get all apparatus for Pemerintahan tab
        $aparaturDesa = AparaturDesa::where('aktif', true)
            ->orderBy('urutan', 'asc')
            ->get();

        // Get all profil data
        $profilDesa = ProfilDesa::where('aktif', true)
            ->orderBy('urutan', 'asc')
            ->get();

        // Get Statistics data
        $stats = Cache::remember('page_statistik_v2', 3600, function () {
            $pendudukByAgama = \App\Models\Penduduk::select('agama', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
                ->groupBy('agama')
                ->get();

            $pendudukByPendidikan = \App\Models\Penduduk::select('pendidikan_terakhir', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
                ->groupBy('pendidikan_terakhir')
                ->get();

            $pendudukByPekerjaan = \App\Models\Penduduk::select('pekerjaan', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
                ->groupBy('pekerjaan')
                ->orderByDesc('total')
                ->limit(10)
                ->get();

            $pendudukByKawin = \App\Models\Penduduk::select('status_perkawinan', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
                ->groupBy('status_perkawinan')
                ->get();

            $pendudukByUsia = \App\Models\Penduduk::get()->groupBy(function ($item) {
                $age = $item->umur;
                if ($age <= 5) return 'Balita (0-5)';
                if ($age <= 12) return 'Anak-anak (6-12)';
                if ($age <= 17) return 'Remaja (13-17)';
                if ($age <= 60) return 'Dewasa (18-60)';
                return 'Lansia (60+)';
            })->map(function ($group) {
                return $group->count();
            });

            $pendudukByGender = \App\Models\Penduduk::select('jenis_kelamin', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
                ->groupBy('jenis_kelamin')
                ->get();

            $pendudukByDarah = \App\Models\Penduduk::select('golongan_darah', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
                ->groupBy('golongan_darah')
                ->get();

            $pendudukByWargaNegara = \App\Models\Penduduk::select('kewarganegaraan', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
                ->groupBy('kewarganegaraan')
                ->get();

            return compact('pendudukByAgama', 'pendudukByPendidikan', 'pendudukByPekerjaan', 'pendudukByKawin', 'pendudukByUsia', 'pendudukByGender', 'pendudukByDarah', 'pendudukByWargaNegara');
        });

        return view('profil', array_merge(
            compact('kepalaDesa', 'profilDesa', 'aparaturDesa'),
            $stats
        ));
    }

    public function aparaturDetail($slug)
    {
        $aparatur = AparaturDesa::where('slug', $slug)
            ->where('aktif', true)
            ->firstOrFail();

        // Related aparatur (same level or nearby in hierarchy)
        $relatedAparatur = AparaturDesa::where('aktif', true)
            ->where('id', '!=', $aparatur->id)
            ->orderBy('urutan', 'asc')
            ->limit(6)
            ->get();

        return view('aparatur-detail', compact('aparatur', 'relatedAparatur'));
    }

    public function statistik()
    {
        $stats = Cache::remember('page_statistik_full', 3600, function () {
            $pendudukByAgama = \App\Models\Penduduk::select('agama', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
                ->groupBy('agama')
                ->get();

            $pendudukByPendidikan = \App\Models\Penduduk::select('pendidikan_terakhir', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
                ->groupBy('pendidikan_terakhir')
                ->get();

            $pendudukByPekerjaan = \App\Models\Penduduk::select('pekerjaan', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
                ->groupBy('pekerjaan')
                ->orderByDesc('total')
                ->limit(10)
                ->get();

            $pendudukByKawin = \App\Models\Penduduk::select('status_perkawinan', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
                ->groupBy('status_perkawinan')
                ->get();

            $pendudukByUsia = \App\Models\Penduduk::get()->groupBy(function ($item) {
                $age = $item->umur;
                if ($age <= 5) return 'Balita (0-5)';
                if ($age <= 12) return 'Anak-anak (6-12)';
                if ($age <= 17) return 'Remaja (13-17)';
                if ($age <= 60) return 'Dewasa (18-60)';
                return 'Lansia (60+)';
            })->map(function ($group) {
                return $group->count();
            });

            $pendudukByGender = \App\Models\Penduduk::select('jenis_kelamin', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
                ->groupBy('jenis_kelamin')
                ->get();

            $pendudukByDarah = \App\Models\Penduduk::select('golongan_darah', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
                ->groupBy('golongan_darah')
                ->get();

            $pendudukByWargaNegara = \App\Models\Penduduk::select('kewarganegaraan', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
                ->groupBy('kewarganegaraan')
                ->get();

            return compact('pendudukByAgama', 'pendudukByPendidikan', 'pendudukByPekerjaan', 'pendudukByKawin', 'pendudukByUsia', 'pendudukByGender', 'pendudukByDarah', 'pendudukByWargaNegara');
        });

        return view('statistik', $stats);
    }

    public function galeri()
    {
        $identitasDesa = \App\Models\IdentitasDesa::first() ?? new \App\Models\IdentitasDesa([
            'nama_desa' => 'Desa Tundagan',
            'alamat' => 'Alamat Desa Belum Diisi',
            'email' => 'admin@desa.id',
            'telepon' => '-',
        ]);

        $search = request('search');
        $kategori = request('kategori');
        $startDate = request('start_date');
        $endDate = request('end_date');
        $sort = request('sort', 'newest');

        $galleries = Galeri::search($search)
            ->byKategori($kategori)
            ->byDateRange($startDate, $endDate)
            ->sortBy($sort)
            ->paginate(12)
            ->withQueryString();

        // Get available categories from database (distinct values)
        $categories = Galeri::distinct()
            ->pluck('kategori')
            ->filter()
            ->sort()
            ->values();

        // AJAX request - return only galleries
        if (request()->ajax()) {
            return view('partials.galeri-list', compact('galleries'))->render();
        }

        return view('galeri', compact('identitasDesa', 'galleries', 'categories', 'search', 'kategori', 'startDate', 'endDate', 'sort'));
    }

    public function informasiPublik()
    {
        $identitasDesa = \App\Models\IdentitasDesa::first() ?? new \App\Models\IdentitasDesa([
            'nama_desa' => 'Desa Tundagan',
            'alamat' => 'Alamat Desa Belum Diisi',
            'email' => 'admin@desa.id',
            'telepon' => '-',
        ]);

        return view('informasi-publik', compact('identitasDesa'));
    }

}

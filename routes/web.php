<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/switch-language/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'id'])) {
        abort(400);
    }

    session()->put('locale', $locale);

    return redirect()->back();
})->name('switch-language');

// Filament Login Redirects
Route::get('/admin/login', fn() => redirect()->route('login'))->name('filament.admin.auth.login');
Route::get('/warga/login', fn() => redirect()->route('login'))->name('filament.warga.auth.login');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [HomeController::class, 'profil'])->name('profil');
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.detail');
Route::get('/umkm', [HomeController::class, 'umkm'])->name('umkm');
Route::get('/umkm/{slug}', [HomeController::class, 'umkmDetail'])->name('umkm.detail');
Route::get('/pemerintahan', [HomeController::class, 'pemerintahan'])->name('pemerintahan');
Route::get('/pemerintahan/{slug}', [HomeController::class, 'aparaturDetail'])->name('aparatur.detail');
Route::get('/statistik', [HomeController::class, 'statistik'])->name('statistik');

// Secure Download Route
Route::get('/download-surat/{record}', App\Http\Controllers\DownloadSuratController::class)
    ->middleware('auth')
    ->name('surat.download');
Route::get('/galeri', [HomeController::class, 'galeri'])->name('galeri');
Route::get('/layanan', [HomeController::class, 'layanan'])->name('layanan');
Route::get('/informasi-publik', [HomeController::class, 'informasiPublik'])->name('informasi-publik');
Route::get('/anggaran-desa', \App\Livewire\AnggaranDesa::class)->name('anggaran-desa');

Route::get('/surat/preview/{id}', [App\Http\Controllers\SuratController::class, 'preview'])->name('surat.preview');
Route::get('/surat/download-lampiran/{id}/{filename}', [App\Http\Controllers\SuratController::class, 'downloadLampiran'])->name('surat.download-lampiran');

Route::get('/manifest.json', function () {
    $identitasDesa = \App\Models\IdentitasDesa::first();
    $logoUrl = $identitasDesa && $identitasDesa->logo 
        ? asset('storage/' . $identitasDesa->logo) 
        : asset('logo-pwa-192.png');

    return response()->json([
        "name" => "Web Desa " . ($identitasDesa->nama_desa ?? "Tundagan"),
        "short_name" => "WebDesa",
        "description" => "Website Resmi Pemerintah Desa " . ($identitasDesa->nama_desa ?? "Tundagan") . ", Kecamatan Watukumpul, Kabupaten Pemalang.",
        "start_url" => "/",
        "display" => "standalone",
        "background_color" => "#ffffff",
        "theme_color" => "#2563eb",
        "icons" => [
            [
                "src" => $logoUrl,
                "sizes" => "192x192",
                "type" => "image/png",
                "purpose" => "any maskable"
            ],
            [
                "src" => $logoUrl,
                "sizes" => "512x512",
                "type" => "image/png",
                "purpose" => "any maskable"
            ]
        ]
    ]);
});


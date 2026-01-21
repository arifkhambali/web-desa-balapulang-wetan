<?php

use App\Models\Galeri;
use App\Models\AparaturDesa;
use Illuminate\Support\Facades\Storage;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Starting image download for Galeri and Aparatur...\n";

// Ensure directories exist
if (!Storage::disk('public')->exists('galeri')) {
    Storage::disk('public')->makeDirectory('galeri');
    echo "Created 'galeri' directory.\n";
}
if (!Storage::disk('public')->exists('aparatur-desa')) {
    Storage::disk('public')->makeDirectory('aparatur-desa');
    echo "Created 'aparatur-desa' directory.\n";
}

// 1. Galeri Images
$galeris = Galeri::all();
echo "Found " . $galeris->count() . " Galeri records.\n";
foreach ($galeris as $g) {
    echo "Processing Galeri ID: {$g->id}\n";
    $seed = 1000 + $g->id;
    $url = "https://picsum.photos/seed/{$seed}/800/600";
    try {
        $contents = @file_get_contents($url);
        if ($contents) {
            $filename = "galeri/galeri-{$g->id}.jpg";
            Storage::disk('public')->put($filename, $contents);
            $g->gambar = $filename;
            $g->save();
            echo "  [OK] Saved to {$filename}\n";
        } else {
            echo "  [FAIL] Could not download image.\n";
        }
    } catch (\Exception $e) {
        echo "  [ERROR] " . $e->getMessage() . "\n";
    }
}

// 2. Aparatur Images
$aparatur = AparaturDesa::all();
echo "Found " . $aparatur->count() . " Aparatur records.\n";
foreach ($aparatur as $a) {
    echo "Processing Aparatur ID: {$a->id}\n";
    $seed = 2000 + $a->id;
    // Using a different source for portraits if possible, but picsum is fine for now
    $url = "https://picsum.photos/seed/{$seed}/400/600"; 
    try {
        $contents = @file_get_contents($url);
        if ($contents) {
            $filename = "aparatur-desa/aparatur-{$a->id}.jpg";
            Storage::disk('public')->put($filename, $contents);
            $a->foto = $filename;
            $a->save();
            echo "  [OK] Saved to {$filename}\n";
        } else {
            echo "  [FAIL] Could not download image.\n";
        }
    } catch (\Exception $e) {
        echo "  [ERROR] " . $e->getMessage() . "\n";
    }
}

// 3. UMKM Images
$umkms = \App\Models\Umkm::all();
echo "Found " . $umkms->count() . " UMKM records.\n";
if (!Storage::disk('public')->exists('umkm')) {
    Storage::disk('public')->makeDirectory('umkm');
    echo "Created 'umkm' directory.\n";
}
foreach ($umkms as $u) {
    echo "Processing UMKM ID: {$u->id}\n";
    $seed = 3000 + $u->id;
    $url = "https://picsum.photos/seed/{$seed}/600/600"; 
    try {
        $contents = @file_get_contents($url);
        if ($contents) {
            $filename = "umkm/produk-{$u->id}.jpg";
            Storage::disk('public')->put($filename, $contents);
            $u->gambar = $filename;
            $u->save();
            echo "  [OK] Saved to {$filename}\n";
        } else {
            echo "  [FAIL] Could not download image.\n";
        }
    } catch (\Exception $e) {
        echo "  [ERROR] " . $e->getMessage() . "\n";
    }
}

// 4. Blog Post Images
$posts = \Firefly\FilamentBlog\Models\Post::all();
echo "Found " . $posts->count() . " Blog Post records.\n";
if (!Storage::disk('public')->exists('blog')) {
    Storage::disk('public')->makeDirectory('blog');
    echo "Created 'blog' directory.\n";
}
foreach ($posts as $p) {
    if ($p->cover_photo_path && !str_starts_with($p->cover_photo_path, 'http')) {
        // Skip if already local
        continue;
    }
    echo "Processing Blog Post ID: {$p->id}\n";
    $seed = 4000 + $p->id;
    $url = "https://picsum.photos/seed/{$seed}/1200/630"; 
    try {
        $contents = @file_get_contents($url);
        if ($contents) {
            $filename = "blog/post-{$p->id}.jpg";
            Storage::disk('public')->put($filename, $contents);
            $p->cover_photo_path = $filename;
            $p->save();
            echo "  [OK] Saved to {$filename}\n";
        } else {
            echo "  [FAIL] Could not download image.\n";
        }
    } catch (\Exception $e) {
        echo "  [ERROR] " . $e->getMessage() . "\n";
    }
}

echo "Done.\n";

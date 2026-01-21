<?php

namespace Database\Seeders;

use App\Models\Galeri;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GaleriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure directory exists
        $path = storage_path('app/public/galeri');
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        // Download some sample images if they don't exist
        $sampleImages = [];
        $imageUrls = [
            'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=800&q=80', // Meeting/Kegiatan
            'https://images.unsplash.com/photo-1526976668912-1a811878dd37?w=800&q=80', // Pembangunan/Infrastruktur
            'https://images.unsplash.com/photo-1533900298318-6b8da08a523e?w=800&q=80', // Event/Budaya
            'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=800&q=80', // Nature/Lainnya
            'https://images.unsplash.com/photo-1511632765486-a01980e01a18?w=800&q=80', // Crowd
            'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?w=800&q=80', // Construction
        ];

        $this->command->info('Downloading sample images...');

        foreach ($imageUrls as $index => $url) {
            $filename = 'sample-' . ($index + 1) . '.jpg';
            $filepath = $path . '/' . $filename;
            
            if (!File::exists($filepath)) {
                try {
                    $contents = file_get_contents($url);
                    if ($contents) {
                        File::put($filepath, $contents);
                        $sampleImages[] = 'galeri/' . $filename;
                        $this->command->info("Downloaded: $filename");
                    }
                } catch (\Exception $e) {
                    $this->command->warn("Failed to download: $url");
                }
            } else {
                $sampleImages[] = 'galeri/' . $filename;
            }
        }

        if (empty($sampleImages)) {
            $this->command->error('No images available. Please check your internet connection.');
            return;
        }

        $kategoris = ['Kegiatan', 'Infrastruktur', 'Budaya', 'Lainnya'];
        $titles = [
            'Kegiatan' => ['Rapat Koordinasi Desa', 'Musyawarah Perencanaan Pembangunan', 'Pelatihan UMKM Desa', 'Posyandu Balita', 'Senam Sehat Bersama'],
            'Infrastruktur' => ['Perbaikan Jalan Desa', 'Pembangunan Jembatan', 'Renovasi Balai Desa', 'Pemasangan Lampu Jalan', 'Pembangunan Saluran Irigasi'],
            'Budaya' => ['Festival Panen Raya', 'Pagelaran Wayang Kulit', 'Lomba Tari Tradisional', 'Upacara Adat Desa', 'Peringatan Hari Kemerdekaan'],
            'Lainnya' => ['Pemandangan Sawah', 'Sungai Bersih', 'Kebun Warga', 'Pasar Desa', 'Gotong Royong Kebersihan'],
        ];

        $this->command->info('Creating 30 dummy gallery items...');

        for ($i = 0; $i < 30; $i++) {
            $kategori = $kategoris[array_rand($kategoris)];
            $titleBase = $titles[$kategori][array_rand($titles[$kategori])];
            
            Galeri::create([
                'judul' => $titleBase . ' - ' . Str::random(5),
                'deskripsi' => 'Dokumentasi kegiatan ' . $titleBase . ' yang dilaksanakan dengan penuh antusiasme oleh warga desa. Kegiatan ini bertujuan untuk memajukan desa dan mempererat tali silaturahmi.',
                'gambar' => $sampleImages[array_rand($sampleImages)],
                'kategori' => $kategori,
                'tanggal_kegiatan' => now()->subDays(rand(1, 365)),
            ]);
        }

        $this->command->info('Galeri seeding completed!');
    }
}

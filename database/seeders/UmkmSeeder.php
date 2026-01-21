<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Umkm;
use App\Models\KategoriUmkm;
use Illuminate\Support\Str;

class UmkmSeeder extends Seeder
{
    public function run()
    {
        // Pastikan ada kategori
        $kategoris = KategoriUmkm::all();
        
        if ($kategoris->isEmpty()) {
            $kategoris = collect([
                KategoriUmkm::create(['nama_kategori' => 'Makanan', 'slug' => 'makanan', 'aktif' => true]),
                KategoriUmkm::create(['nama_kategori' => 'Minuman', 'slug' => 'minuman', 'aktif' => true]),
                KategoriUmkm::create(['nama_kategori' => 'Kerajinan', 'slug' => 'kerajinan', 'aktif' => true]),
                KategoriUmkm::create(['nama_kategori' => 'Fashion', 'slug' => 'fashion', 'aktif' => true]),
                KategoriUmkm::create(['nama_kategori' => 'Pertanian', 'slug' => 'pertanian', 'aktif' => true]),
            ]);
        }

        $namaProduk = [
            'Keripik Singkong Renyah',
            'Keripik Pisang Manis',
            'Keripik Tempe Original',
            'Sambal Pedas Nusantara',
            'Kopi Robusta Premium',
            'Teh Hijau Organik',
            'Jus Jambu Merah',
            'Sirup Markisa Segar',
            'Tas Anyaman Pandan',
            'Dompet Kulit Asli',
            'Sepatu Rajut Handmade',
            'Kaos Batik Modern',
            'Beras Organik Premium',
            'Sayur Hidroponik Segar',
            'Madu Hutan Asli',
            'Telur Ayam Kampung',
            'Dodol Durian Khas',
            'Kue Kering Lebaran',
            'Brownies Coklat Lumer',
            'Roti Sobek Lembut',
        ];

        $namaPenjual = [
            'Ibu Siti',
            'Pak Budi',
            'Ibu Ani',
            'Pak Joko',
            'Ibu Rina',
            'Pak Agus',
            'Ibu Dewi',
            'Pak Hadi',
            'Ibu Yuni',
            'Pak Dedi',
        ];

        $deskripsi = [
            'Produk berkualitas tinggi dengan bahan pilihan terbaik. Dibuat dengan resep turun temurun yang sudah terbukti kelezatannya.',
            'Hasil karya tangan pengrajin lokal yang berpengalaman. Setiap produk dibuat dengan penuh dedikasi dan ketelitian.',
            'Produk organik tanpa bahan pengawet dan pewarna buatan. Aman untuk dikonsumsi seluruh keluarga.',
            'Dibuat dari bahan-bahan alami pilihan dengan proses produksi yang higienis dan modern.',
            'Produk unggulan desa kami yang sudah terkenal hingga ke berbagai daerah. Kualitas terjamin!',
        ];

        // Buat 100 produk
        for ($i = 1; $i <= 100; $i++) {
            $kategori = $kategoris->random();
            $nama = $namaProduk[array_rand($namaProduk)] . ' ' . $i;
            $slug = Str::slug($nama);
            
            // Pastikan slug unik
            $originalSlug = $slug;
            $counter = 1;
            while (Umkm::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            Umkm::create([
                'nama_produk' => $nama,
                'slug' => $slug,
                'kategori_umkm_id' => $kategori->id,
                'deskripsi' => $deskripsi[array_rand($deskripsi)],
                'harga' => rand(10, 500) * 1000, // 10rb - 500rb
                'stok' => rand(10, 100),
                'status' => ['tersedia', 'tersedia', 'tersedia', 'habis'][array_rand(['tersedia', 'tersedia', 'tersedia', 'habis'])],
                'nama_penjual' => $namaPenjual[array_rand($namaPenjual)],
                'kontak' => '08' . rand(1000000000, 9999999999),
                'aktif' => true,
                'featured' => $i <= 5 ? true : false, // 5 produk pertama jadi featured
            ]);
        }
    }
}

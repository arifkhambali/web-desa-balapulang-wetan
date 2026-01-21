<?php

namespace Database\Seeders;

use App\Models\ProfilDesa;
use Illuminate\Database\Seeder;

class ProfilDesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profiles = [
            [
                'judul' => 'Sejarah Desa',
                'slug' => 'sejarah-desa',
                'konten' => '<p>Berdiri sejak tahun 1950, Desa Tundagan memiliki sejarah panjang gotong royong dan kearifan lokal yang masih terjaga hingga kini. Awalnya merupakan pemukiman kecil yang berkembang menjadi desa agraris yang makmur.</p>',
                'icon' => 'fa-solid fa-clock-rotate-left',
                'urutan' => 1,
                'aktif' => true,
            ],
            [
                'judul' => 'Visi & Misi',
                'slug' => 'visi-misi',
                'konten' => '<p><strong>Visi:</strong><br>Mewujudkan masyarakat yang mandiri, cerdas, dan sejahtera berlandaskan nilai-nilai agama dan budaya.</p><p><strong>Misi:</strong><br>1. Meningkatkan kualitas pelayanan publik.<br>2. Mengembangkan potensi ekonomi lokal.<br>3. Membangun infrastruktur yang berkelanjutan.</p>',
                'icon' => 'fa-solid fa-bullseye',
                'urutan' => 2,
                'aktif' => true,
            ],
            [
                'judul' => 'Letak Geografis',
                'slug' => 'letak-geografis',
                'konten' => '<p>Terletak di dataran tinggi dengan luas wilayah 500 Ha, dikelilingi perbukitan hijau dan sumber mata air yang melimpah. Berbatasan langsung dengan Hutan Lindung di sebelah utara dan Sungai Besar di sebelah selatan.</p>',
                'icon' => 'fa-solid fa-map-location-dot',
                'urutan' => 3,
                'aktif' => true,
            ],
            [
                'judul' => 'Demografi',
                'slug' => 'demografi',
                'konten' => '<p>Penduduk yang heterogen namun harmonis, terdiri dari berbagai latar belakang profesi dengan mayoritas petani dan pedagang. Total penduduk mencapai 5.000 jiwa dengan komposisi usia produktif yang dominan.</p>',
                'icon' => 'fa-solid fa-users',
                'urutan' => 4,
                'aktif' => true,
            ],
            [
                'judul' => 'Potensi Desa',
                'slug' => 'potensi-desa',
                'konten' => '<p>Penghasil komoditas pertanian unggulan seperti padi organik, sayur mayur, dan memiliki potensi wisata alam yang memukau seperti Air Terjun Bidadari dan Agrowisata Kebun Teh.</p>',
                'icon' => 'fa-solid fa-wheat-awn',
                'urutan' => 5,
                'aktif' => true,
            ],
            [
                'judul' => 'Prestasi Desa',
                'slug' => 'prestasi-desa',
                'konten' => '<p>Juara 1 Lomba Desa Tingkat Kabupaten tahun 2023 dan Penghargaan Desa Digital Terbaik tahun 2024. Serta berbagai prestasi di bidang seni dan olahraga tingkat provinsi.</p>',
                'icon' => 'fa-solid fa-trophy',
                'urutan' => 6,
                'aktif' => true,
            ],
        ];

        foreach ($profiles as $profile) {
            ProfilDesa::create($profile);
        }
    }
}

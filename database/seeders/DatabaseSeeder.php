<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Berita;
use App\Models\Umkm;
use App\Models\Penduduk;
use App\Models\JenisSurat;
use App\Models\AparaturDesa;
use App\Models\Galeri;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin User
        User::updateOrCreate(
            ['email' => 'admin@desa.id'],
            [
                'name' => 'Admin Desa',
                'role' => 'admin',
                'password' => Hash::make('password'), // Password default: password
                'email_verified_at' => now(),
            ]
        );

        // 1b. Create Kepala Desa User
        User::updateOrCreate(
            ['email' => 'kades@desa.id'],
            [
                'name' => 'Kepala Desa',
                'role' => 'kades',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // 1c. Create Warga User
        User::updateOrCreate(
            ['email' => 'warga@desa.id'],
            [
                'name' => 'Warga Desa',
                'role' => 'warga',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Create Penduduk Dummy (20 Data)
        $penduduks = [
            [
                'nik' => '3301010101010001',
                'nama_lengkap' => 'Budi Santoso',
                'jenis_kelamin' => 'Laki-laki',
                'agama' => 'Islam',
                'pekerjaan' => 'Petani',
                'pendidikan_terakhir' => 'SMA/Sederajat',
                'status_perkawinan' => 'Kawin',
                'umur' => 45
            ],
            [
                'nik' => '3301010101010002',
                'nama_lengkap' => 'Siti Aminah',
                'jenis_kelamin' => 'Perempuan',
                'agama' => 'Islam',
                'pekerjaan' => 'Ibu Rumah Tangga',
                'pendidikan_terakhir' => 'SMP/Sederajat',
                'status_perkawinan' => 'Kawin',
                'umur' => 42
            ],
            [
                'nik' => '3301010101010003',
                'nama_lengkap' => 'Ahmad Rizki',
                'jenis_kelamin' => 'Laki-laki',
                'agama' => 'Islam',
                'pekerjaan' => 'Wiraswasta',
                'pendidikan_terakhir' => 'S1',
                'status_perkawinan' => 'Belum Kawin',
                'umur' => 25,
                'golongan_darah' => 'O',
                'kewarganegaraan' => 'WNI',
            ],
            // Tambahkan data random lainnya
        ];

        // Generate random penduduk
        for ($i = 0; $i < 10000; $i++) {
            Penduduk::create([
                'nik' => '3301' . rand(100000000000, 999999999999),
                'no_kk' => '3301' . rand(100000000000, 999999999999),
                'nama_lengkap' => 'Warga ' . ($i + 1),
                'tempat_lahir' => 'Makmur',
                'tanggal_lahir' => now()->subYears(rand(1, 80))->subDays(rand(1, 365)),
                'jenis_kelamin' => rand(0, 1) ? 'Laki-laki' : 'Perempuan',
                'agama' => ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha'][rand(0, 4)],
                'pendidikan_terakhir' => ['SD/Sederajat', 'SMP/Sederajat', 'SMA/Sederajat', 'S1'][rand(0, 3)],
                'pekerjaan' => ['Petani', 'PNS', 'Wiraswasta', 'Buruh', 'Pelajar/Mahasiswa'][rand(0, 4)],
                'status_perkawinan' => ['Belum Kawin', 'Kawin', 'Cerai Hidup'][rand(0, 2)],
                'status_keluarga' => 'Kepala Keluarga',
                'alamat' => 'Jl. Desa No. ' . rand(1, 100),
                'rt' => '00' . rand(1, 5),
                'rw' => '00' . rand(1, 3),
                'golongan_darah' => ['A', 'B', 'AB', 'O', '-'][rand(0, 4)],
                'kewarganegaraan' => ['WNI', 'WNA'][rand(0, 10) > 9 ? 1 : 0], // Mostly WNI
            ]);
        }

        // 3. Create Berita Dummy
        Berita::create([
            'judul' => 'Penyaluran Bantuan Langsung Tunai (BLT) Tahap 1',
            'slug' => 'penyaluran-blt-tahap-1',
            'kategori' => 'Pemerintahan',
            'konten' => 'Pemerintah Desa Tundagan telah menyalurkan Bantuan Langsung Tunai (BLT) tahap pertama kepada 100 Keluarga Penerima Manfaat (KPM). Kegiatan ini dilaksanakan di Balai Desa dengan tetap mematuhi protokol kesehatan.',
            'penulis' => 'Admin Desa',
            'status' => 'published',
            'published_at' => now(),
            'views' => 150
        ]);

        Berita::create([
            'judul' => 'Gotong Royong Membersihkan Saluran Irigasi',
            'slug' => 'gotong-royong-irigasi',
            'kategori' => 'Sosial',
            'konten' => 'Warga Desa Tundagan antusias mengikuti kegiatan gotong royong membersihkan saluran irigasi persawahan. Kegiatan ini bertujuan untuk melancarkan aliran air menjelang musim tanam padi.',
            'penulis' => 'Admin Desa',
            'status' => 'published',
            'published_at' => now()->subDays(2),
            'views' => 85
        ]);

        // 4. Create UMKM Dummy
        Umkm::create([
            'nama_produk' => 'Keripik Singkong "Renyah"',
            'slug' => 'keripik-singkong-renyah',
            'kategori' => 'Makanan',
            'deskripsi' => 'Keripik singkong aneka rasa (original, balado, keju) yang renyah dan gurih. Dibuat dari singkong pilihan hasil panen petani lokal.',
            'harga' => 15000,
            'nama_penjual' => 'Ibu Ani',
            'kontak' => '081234567890',
            'status' => 'tersedia',
            'stok' => 50
        ]);

        Umkm::create([
            'nama_produk' => 'Tas Anyaman Bambu',
            'slug' => 'tas-anyaman-bambu',
            'kategori' => 'Kerajinan',
            'deskripsi' => 'Tas cantik ramah lingkungan yang terbuat dari anyaman bambu berkualitas. Cocok untuk belanja atau souvenir.',
            'harga' => 45000,
            'nama_penjual' => 'Pak Budi',
            'kontak' => '081234567891',
            'status' => 'pre-order',
            'stok' => 0
        ]);

        // 5. Create Jenis Surat
        $surats = [
            [
                'nama_surat' => 'Surat Keterangan Domisili',
                'kode' => 'SKD',
                'deskripsi' => 'Surat keterangan yang menyatakan status domisili seseorang di desa.',
                'persyaratan' => json_encode(['KTP', 'KK', 'Surat Pengantar RT/RW']),
            ],
            [
                'nama_surat' => 'Surat Keterangan Usaha',
                'kode' => 'SKU',
                'deskripsi' => 'Surat keterangan yang menyatakan bahwa seseorang memiliki usaha di desa.',
                'persyaratan' => json_encode(['KTP', 'KK', 'Foto Usaha']),
            ],
            [
                'nama_surat' => 'Surat Keterangan Tidak Mampu',
                'kode' => 'SKTM',
                'deskripsi' => 'Surat keterangan untuk keperluan pengajuan bantuan atau beasiswa.',
                'persyaratan' => json_encode(['KTP', 'KK', 'Foto Rumah (Depan, Samping, Dalam)']),
            ],
            [
                'nama_surat' => 'Surat Pengantar SKCK',
                'kode' => 'SKCK',
                'deskripsi' => 'Surat pengantar untuk pembuatan SKCK di kepolisian.',
                'persyaratan' => json_encode(['KTP', 'KK', 'Akte Kelahiran']),
            ],
        ];

        foreach ($surats as $surat) {
            JenisSurat::create($surat);
        }

        // 3. Link Warga User to First Penduduk
        $firstPenduduk = Penduduk::first();
        if ($firstPenduduk) {
            $wargaUser = User::where('email', 'warga@desa.id')->first();
            if ($wargaUser) {
                $wargaUser->update(['penduduk_id' => $firstPenduduk->id]);
            }
        }
        // 6. Create Identitas Desa
        \App\Models\IdentitasDesa::create([
            'nama_desa' => 'Desa Tundagan',
            'alamat' => 'Jl. Raya Desa No. 1, Kec. Sejahtera, Kab. Makmur',
            'email' => 'info@desamajujaya.id',
            'telepon' => '021-12345678',
        ]);

        // 7. Create Profil Desa (Visi Misi & Sejarah)
        \App\Models\ProfilDesa::create([
            'judul' => 'Visi & Misi',
            'slug' => 'visi-misi',
            'konten' => "<strong>Visi:</strong><br>Mewujudkan Desa Tundagan yang Mandiri, Sejahtera, dan Berbudaya.<br><br><strong>Misi:</strong><br>1. Meningkatkan pelayanan publik.<br>2. Mengembangkan potensi ekonomi desa.<br>3. Melestarikan budaya lokal.",
            'urutan' => 1,
            'aktif' => true,
        ]);

        \App\Models\ProfilDesa::create([
            'judul' => 'Sejarah Desa',
            'slug' => 'sejarah-desa',
            'konten' => 'Desa ini didirikan pada tahun 1945...',
            'urutan' => 2,
            'aktif' => true,
        ]);

        $this->call([
            AparaturDesaSeeder::class,
            FilamentBlogSeeder::class,
            // PostSeeder::class,
            // CommentSeeder::class,
        ]);
    }
}

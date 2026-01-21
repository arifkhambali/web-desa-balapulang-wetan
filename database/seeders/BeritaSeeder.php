<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriBerita;
use App\Models\Berita;
use Illuminate\Support\Str;

class BeritaSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data lama
        $this->command->info('🗑️  Menghapus data berita dan kategori lama...');
        
        // Disable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Berita::truncate();
        KategoriBerita::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('📝 Membuat kategori berita...');
        
        $categories = [
            ['nama_kategori' => 'Pemerintahan Desa', 'deskripsi' => 'Berita seputar pemerintahan dan kebijakan desa', 'aktif' => true],
            ['nama_kategori' => 'Pembangunan', 'deskripsi' => 'Informasi pembangunan infrastruktur desa', 'aktif' => true],
            ['nama_kategori' => 'Kesehatan', 'deskripsi' => 'Berita kesehatan dan posyandu', 'aktif' => true],
            ['nama_kategori' => 'Pendidikan', 'deskripsi' => 'Informasi pendidikan dan sekolah', 'aktif' => true],
            ['nama_kategori' => 'Keagamaan', 'deskripsi' => 'Kegiatan keagamaan masyarakat', 'aktif' => true],
            ['nama_kategori' => 'Ekonomi', 'deskripsi' => 'Perkembangan ekonomi dan UMKM desa', 'aktif' => true],
            ['nama_kategori' => 'Pertanian', 'deskripsi' => 'Informasi pertanian dan perkebunan', 'aktif' => true],
            ['nama_kategori' => 'Lingkungan', 'deskripsi' => 'Berita lingkungan dan kebersihan', 'aktif' => true],
            ['nama_kategori' => 'Sosial Budaya', 'deskripsi' => 'Kegiatan sosial dan budaya masyarakat', 'aktif' => true],
            ['nama_kategori' => 'Olahraga', 'deskripsi' => 'Event dan kegiatan olahraga', 'aktif' => true],
            ['nama_kategori' => 'Kepemudaan', 'deskripsi' => 'Kegiatan karang taruna dan pemuda', 'aktif' => true],
            ['nama_kategori' => 'PKK', 'deskripsi' => 'Kegiatan Pemberdayaan Kesejahteraan Keluarga', 'aktif' => true],
            ['nama_kategori' => 'Keamanan', 'deskripsi' => 'Informasi keamanan dan ketertiban desa', 'aktif' => true],
            ['nama_kategori' => 'Pariwisata', 'deskripsi' => 'Potensi wisata dan destinasi desa', 'aktif' => true],
            ['nama_kategori' => 'Pengumuman', 'deskripsi' => 'Pengumuman resmi dari pemerintah desa', 'aktif' => true],
        ];

        $createdCategories = [];
        foreach ($categories as $category) {
            $createdCategories[] = KategoriBerita::create($category);
        }

        // Array berita dummy dengan konten yang bervariasi
        $beritaTemplates = [
            [
                'prefix' => 'Pelaksanaan',
                'topics' => ['Musyawarah Desa', 'Gotong Royong', 'Rapat RT/RW', 'Kerja Bakti', 'Sosialisasi Program', 'Vaksinasi Massal', 'Posyandu Balita', 'Festival Desa', 'Lomba Kebersihan', 'Pelatihan Wirausaha']
            ],
            [
                'prefix' => 'Peresmian',
                'topics' => ['Jalan Desa Baru', 'Balai Desa', 'Jembatan Penghubung', 'Sarana Olahraga', 'Taman Bermain', 'MCK Umum', 'Gedung Serbaguna', 'Masjid Desa', 'Puskesmas Pembantu', 'Perpustakaan Desa']
            ],
            [
                'prefix' => 'Keberhasilan',
                'topics' => ['Panen Raya Padi', 'Program BLT', 'Lomba Desa Sehat', 'Pengentasan Kemiskinan', 'Literasi Desa', 'Wirausaha Muda', 'Inovasi Pertanian', 'Penghijauan Desa', 'Sanitasi Total', 'Desa Digital']
            ],
            [
                'prefix' => 'Program',
                'topics' => ['Bantuan Sosial', 'Beasiswa Pendidikan', 'Kredit Usaha Rakyat', 'Pelatihan Keterampilan', 'Pemberdayaan Perempuan', 'Perbaikan Jalan', 'Pengadaan Air Bersih', 'Dana Desa 2024', 'Stunting Prevention', 'Smart Village']
            ],
        ];

        $penulisList = [
            'Admin Desa', 'Sekretaris Desa', 'Humas Desa', 'Kaur Pembangunan', 
            'Tim Redaksi', 'Kepala Desa', 'Kasi Pemerintahan', 'Operator Desa'
        ];

        $loremParagraphs = [
            'Kegiatan ini diselenggarakan sebagai upaya meningkatkan kesejahteraan masyarakat desa serta memperkuat gotong royong antar warga. Partisipasi aktif dari seluruh elemen masyarakat menjadi kunci keberhasilan program yang telah direncanakan dengan matang oleh pemerintah desa.',
            'Antusiasme warga sangat tinggi dalam mengikuti program ini. Hal ini terlihat dari jumlah peserta yang melebihi target awal. Kepala Desa menyampaikan apresiasi setinggi-tingginya kepada seluruh warga yang telah berpartisipasi aktif dalam kegiatan ini.',
            'Program ini merupakan bagian dari upaya pemerintah desa dalam mewujudkan visi misi pembangunan desa yang berkelanjutan. Dengan melibatkan seluruh komponen masyarakat, diharapkan program ini dapat memberikan manfaat yang optimal bagi kemajuan desa.',
            'Berbagai kendala yang dihadapi dalam pelaksanaan program dapat diatasi dengan baik berkat kerja sama yang solid antara pemerintah desa dan masyarakat. Semangat gotong royong yang masih kental menjadi modal utama dalam mencapai tujuan bersama.',
            'Ke depan, pemerintah desa akan terus mengembangkan program-program inovatif yang bermanfaat bagi masyarakat. Masukan dan kritik membangun dari warga sangat diharapkan demi perbaikan dan peningkatan kualitas pelayanan publik.',
            'Keberhasilan program ini tidak lepas dari dukungan berbagai pihak, termasuk pemerintah kecamatan, kabupaten, serta lembaga mitra yang telah berkontribusi. Sinergi yang terjalin dengan baik menjadi fondasi kuat dalam pembangunan desa.',
        ];

        // Generate 80 berita
        for ($i = 1; $i <= 80; $i++) {
            $template = $beritaTemplates[array_rand($beritaTemplates)];
            $topic = $template['topics'][array_rand($template['topics'])];
            $judul = $template['prefix'] . ' ' . $topic . ' ' . (rand(0, 100) > 50 ? 'Tahun 2024' : 'di Desa Tundagan');
            
            // Random kategori
            $kategori = $createdCategories[array_rand($createdCategories)];
            
            // Random penulis
            $penulis = $penulisList[array_rand($penulisList)];
            
            // Generate konten dengan 3-6 paragraf
            $numParagraphs = rand(3, 6);
            $kontenArray = [];
            for ($p = 0; $p < $numParagraphs; $p++) {
                $kontenArray[] = '<p>' . $loremParagraphs[array_rand($loremParagraphs)] . '</p>';
            }
            $konten = implode("\n\n", $kontenArray);
            
            // Random published date dalam 3 bulan terakhir
            $daysAgo = rand(1, 90);
            $publishedAt = now()->subDays($daysAgo);
            
            // Random views
            $views = rand(10, 500);
            
            Berita::create([
                'judul' => $judul,
                'slug' => Str::slug($judul) . '-' . $i,
                'kategori_berita_id' => $kategori->id,
                'konten' => $konten,
                'penulis' => $penulis,
                'views' => $views,
                'status' => 'published',
                'published_at' => $publishedAt,
                'gambar' => null, // Bisa ditambahkan jika ada gambar
            ]);
        }

        $this->command->info('✅ Berhasil membuat 15 kategori berita dan 80 berita!');
    }
}

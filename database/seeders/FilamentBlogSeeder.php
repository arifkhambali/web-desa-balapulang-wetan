<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class FilamentBlogSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🚀 Memulai seeding blog posts...');
        
        // Get or create users for authors
        $users = User::all();
        if ($users->isEmpty()) {
            $this->command->warn('⚠️  Tidak ada user, membuat user default...');
            $user = User::create([
                'name' => 'Admin Blog',
                'email' => 'admin@blog.com',
                'password' => bcrypt('password'),
            ]);
            $users = collect([$user]);
        }

        // Clear existing data
        $this->command->info('🗑️  Menghapus data blog lama...');
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('fblog_post_fblog_tag')->truncate();
        DB::table('fblog_category_fblog_post')->truncate();
        DB::table('fblog_seo_details')->truncate();
        DB::table('fblog_comments')->truncate();
        DB::table('fblog_posts')->truncate();
        DB::table('fblog_categories')->truncate();
        DB::table('fblog_tags')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create Categories
        $this->command->info('📁 Membuat kategori blog...');
        $categories = [
            ['name' => 'Pemerintahan Desa', 'slug' => 'pemerintahan-desa'],
            ['name' => 'Pembangunan', 'slug' => 'pembangunan'],
            ['name' => 'Kesehatan', 'slug' => 'kesehatan'],
            ['name' => 'Pendidikan', 'slug' => 'pendidikan'],
            ['name' => 'Keagamaan', 'slug' => 'keagamaan'],
            ['name' => 'Ekonomi & UMKM', 'slug' => 'ekonomi-umkm'],
            ['name' => 'Pertanian', 'slug' => 'pertanian'],
            ['name' => 'Lingkungan', 'slug' => 'lingkungan'],
            ['name' => 'Sosial Budaya', 'slug' => 'sosial-budaya'],
            ['name' => 'Olahraga', 'slug' => 'olahraga'],
            ['name' => 'Kepemudaan', 'slug' => 'kepemudaan'],
            ['name' => 'PKK', 'slug' => 'pkk'],
            ['name' => 'Keamanan', 'slug' => 'keamanan'],
            ['name' => 'Pariwisata', 'slug' => 'pariwisata'],
            ['name' => 'Teknologi', 'slug' => 'teknologi'],
        ];

        $categoryIds = [];
        foreach ($categories as $category) {
            $id = DB::table('fblog_categories')->insertGetId([
                'name' => $category['name'],
                'slug' => $category['slug'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $categoryIds[] = $id;
        }

        // Create Tags
        $this->command->info('🏷️  Membuat tags...');
        $tags = [
            'Pengumuman', 'Berita Terkini', 'Event', 'Program Desa', 'Kegiatan',
            'Sosialisasi', 'Pelatihan', 'Workshop', 'Gotong Royong', 'Musyawarah',
            'Inovasi', 'Prestasi', 'Kerjasama', 'Bantuan Sosial', 'Infrastruktur',
            'Digitalisasi', 'Pemberdayaan', 'Kesejahteraan', 'Pelayanan Publik', 'Transparansi',
            'Partisipasi', 'Kolaborasi', 'Edukasi', 'Kampanye', 'Festival',
        ];

        $tagIds = [];
        foreach ($tags as $tag) {
            $id = DB::table('fblog_tags')->insertGetId([
                'name' => $tag,
                'slug' => Str::slug($tag),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $tagIds[] = $id;
        }

        // Blog post templates
        $postTemplates = [
            [
                'title_prefix' => 'Pelaksanaan',
                'topics' => [
                    'Musyawarah Desa Tahun 2024',
                    'Gotong Royong Pembersihan Lingkungan',
                    'Rapat Koordinasi RT/RW',
                    'Kerja Bakti Bersama Warga',
                    'Sosialisasi Program Dana Desa',
                    'Vaksinasi Massal COVID-19',
                    'Posyandu Balita dan Lansia',
                    'Festival Budaya Desa',
                    'Lomba Kebersihan Antar RT',
                    'Pelatihan Wirausaha Muda',
                ],
            ],
            [
                'title_prefix' => 'Peresmian',
                'topics' => [
                    'Jalan Desa Baru Sepanjang 2 Km',
                    'Balai Desa Modern',
                    'Jembatan Penghubung Antar Dusun',
                    'Lapangan Olahraga Multifungsi',
                    'Taman Bermain Anak',
                    'MCK Umum Ramah Lingkungan',
                    'Gedung Serbaguna Desa',
                    'Masjid Al-Ikhlas',
                    'Puskesmas Pembantu Desa',
                    'Perpustakaan Digital Desa',
                ],
            ],
            [
                'title_prefix' => 'Keberhasilan',
                'topics' => [
                    'Panen Raya Padi 100 Hektar',
                    'Program Bantuan Langsung Tunai',
                    'Lomba Desa Sehat Tingkat Kabupaten',
                    'Pengentasan Kemiskinan Ekstrem',
                    'Program Literasi Digital',
                    'Inkubasi Wirausaha Muda Desa',
                    'Inovasi Pertanian Organik',
                    'Program Penghijauan 1000 Pohon',
                    'Sanitasi Total Berbasis Masyarakat',
                    'Transformasi Desa Digital',
                ],
            ],
            [
                'title_prefix' => 'Program',
                'topics' => [
                    'Bantuan Sosial untuk Warga Kurang Mampu',
                    'Beasiswa Pendidikan Anak Berprestasi',
                    'Kredit Usaha Rakyat Mikro',
                    'Pelatihan Keterampilan Menjahit',
                    'Pemberdayaan Perempuan Desa',
                    'Perbaikan Jalan Lingkungan',
                    'Pengadaan Air Bersih',
                    'Dana Desa untuk Infrastruktur',
                    'Pencegahan Stunting Terintegrasi',
                    'Smart Village Technology',
                ],
            ],
            [
                'title_prefix' => 'Peningkatan',
                'topics' => [
                    'Kualitas Pelayanan Administrasi Desa',
                    'Kapasitas Aparatur Desa',
                    'Produktivitas Pertanian Lokal',
                    'Kesadaran Masyarakat tentang Kesehatan',
                    'Partisipasi Pemuda dalam Pembangunan',
                    'Ekonomi Kreatif Berbasis Lokal',
                    'Infrastruktur Jalan Desa',
                    'Akses Internet di Seluruh Dusun',
                    'Kualitas Pendidikan Anak Desa',
                    'Keamanan dan Ketertiban Desa',
                ],
            ],
        ];

        // Content paragraphs dengan HTML formatting yang lebih kaya
        $contentParagraphs = [
            '<p>Kegiatan ini diselenggarakan sebagai upaya konkret dalam meningkatkan kesejahteraan masyarakat desa serta memperkuat semangat gotong royong yang telah menjadi tradisi turun temurun. Partisipasi aktif dari seluruh elemen masyarakat, mulai dari tokoh masyarakat, pemuda, hingga ibu-ibu PKK, menjadi kunci utama keberhasilan program yang telah direncanakan dengan matang oleh pemerintah desa bersama BPD.</p>',
            
            '<p>Antusiasme warga sangat tinggi dalam mengikuti program ini, terlihat dari jumlah peserta yang mencapai lebih dari 200 orang, melebihi target awal yang ditetapkan. Kepala Desa dalam sambutannya menyampaikan apresiasi setinggi-tingginya kepada seluruh warga yang telah meluangkan waktu dan tenaga untuk berpartisipasi aktif.</p>',
            
            '<h3>Tujuan dan Manfaat Program</h3><p>Program ini merupakan bagian integral dari upaya pemerintah desa dalam mewujudkan visi misi pembangunan desa yang berkelanjutan dan inklusif. Dengan melibatkan seluruh komponen masyarakat tanpa terkecuali, diharapkan program ini dapat memberikan manfaat yang optimal dan merata bagi seluruh lapisan masyarakat.</p>',
            
            '<p>Berbagai kendala teknis dan non-teknis yang dihadapi dalam pelaksanaan program dapat diatasi dengan baik berkat kerja sama yang solid antara pemerintah desa, lembaga kemasyarakatan, dan seluruh warga. Semangat gotong royong yang masih kental dalam kehidupan masyarakat desa menjadi modal sosial yang sangat berharga dalam mencapai tujuan bersama untuk kemajuan desa.</p>',
            
            '<blockquote class="border-l-4 border-purple-500 pl-4 italic my-4 text-slate-600 dark:text-slate-400">"Kebersamaan dan kerja keras adalah kunci utama dalam membangun desa yang maju dan sejahtera. Mari kita terus bersinergi untuk masa depan yang lebih baik." - Kepala Desa</blockquote>',
            
            '<h3>Dukungan dan Kolaborasi</h3><p>Keberhasilan program ini tidak lepas dari dukungan berbagai pihak, termasuk pemerintah kecamatan, kabupaten, serta berbagai lembaga mitra yang telah berkontribusi baik secara finansial maupun non-finansial. Sinergi yang terjalin dengan baik antara semua stakeholder menjadi fondasi kuat dalam mewujudkan pembangunan desa yang berkelanjutan dan berdampak nyata bagi masyarakat.</p>',
            
            '<h3>Transparansi dan Akuntabilitas</h3><p>Dokumentasi lengkap kegiatan ini telah dipublikasikan melalui berbagai media sosial resmi desa untuk memberikan transparansi dan akuntabilitas kepada publik. Masyarakat dapat mengakses informasi lebih detail melalui website resmi desa atau datang langsung ke kantor desa pada jam kerja untuk mendapatkan informasi lebih lanjut.</p>',
            
            '<p>Pemerintah desa mengajak seluruh warga untuk terus menjaga dan merawat hasil-hasil pembangunan yang telah dicapai bersama. Kepemilikan bersama atas aset-aset desa akan menjamin keberlanjutan manfaatnya untuk generasi mendatang. Mari kita bersama-sama membangun desa yang lebih maju, sejahtera, dan bermartabat.</p>',
            
            '<h3>Monitoring dan Evaluasi</h3><p>Evaluasi menyeluruh akan dilakukan secara berkala untuk memastikan program berjalan sesuai rencana dan memberikan dampak positif yang terukur. Tim monitoring dan evaluasi yang dibentuk khusus akan melakukan pendampingan intensif serta memberikan laporan rutin kepada masyarakat melalui forum-forum musyawarah desa.</p>',
            
            '<p><strong>Dengan semangat kebersamaan dan kerja keras</strong>, kita yakin dapat mewujudkan desa yang mandiri, maju, dan sejahtera. Setiap kontribusi, sekecil apapun, sangat berarti dalam perjalanan panjang pembangunan desa. Mari kita terus bersinergi dan berkolaborasi untuk masa depan yang lebih cerah bagi anak cucu kita.</p>',
            
            '<ul class="list-disc pl-6 my-4 space-y-2"><li>Meningkatkan partisipasi masyarakat dalam pembangunan desa</li><li>Memperkuat gotong royong dan kebersamaan warga</li><li>Mengoptimalkan pemanfaatan sumber daya lokal</li><li>Meningkatkan transparansi dan akuntabilitas pemerintah desa</li></ul>',
            
            '<p>Program ini juga sejalan dengan Sustainable Development Goals (SDGs) khususnya dalam upaya pengentasan kemiskinan, peningkatan kesehatan dan pendidikan, serta pembangunan infrastruktur yang berkelanjutan. Komitmen pemerintah desa dalam mewujudkan tujuan-tujuan tersebut terus ditingkatkan melalui berbagai program inovatif dan responsif.</p>',
        ];

        $introSentences = [
            'Dalam rangka meningkatkan kualitas pelayanan kepada masyarakat, ',
            'Sebagai wujud komitmen terhadap pembangunan berkelanjutan, ',
            'Melanjutkan program prioritas tahun ini, ',
            'Dengan penuh antusias dan semangat kebersamaan, ',
            'Menyambut era digitalisasi dan modernisasi desa, ',
            'Dalam upaya mewujudkan desa yang lebih maju, ',
            'Sebagai bagian dari program pemberdayaan masyarakat, ',
            'Dengan dukungan penuh dari seluruh elemen masyarakat, ',
            'Melaksanakan amanat peraturan desa, ',
            'Dalam rangka merayakan momentum penting ini, ',
        ];

        // Generate 100 blog posts
        $this->command->info('📝 Membuat 100 blog posts...');
        $bar = $this->command->getOutput()->createProgressBar(100);
        $bar->start();

        for ($i = 1; $i <= 100; $i++) {
            // Random template
            $template = $postTemplates[array_rand($postTemplates)];
            $topic = $template['topics'][array_rand($template['topics'])];
            $title = $template['title_prefix'] . ' ' . $topic;
            
            // Random subtitle
            $subtitles = [
                'Langkah Nyata Menuju Desa Maju',
                'Wujud Komitmen Pemerintah Desa',
                'Membawa Perubahan Positif',
                'Meningkatkan Kesejahteraan Warga',
                'Inovasi untuk Kemajuan Bersama',
                'Membangun Masa Depan Lebih Baik',
                'Kolaborasi untuk Hasil Maksimal',
                'Transparansi dan Akuntabilitas',
                'Partisipasi Aktif Masyarakat',
                'Menuju Desa Mandiri dan Sejahtera',
            ];
            $subTitle = $subtitles[array_rand($subtitles)];
            
            // Generate rich content
            $numParagraphs = rand(5, 8);
            $selectedParagraphs = [];
            
            // Add intro
            $intro = $introSentences[array_rand($introSentences)] . 
                     'pemerintah desa telah melaksanakan program yang mendapat sambutan positif dari masyarakat.';
            $selectedParagraphs[] = '<p>' . $intro . '</p>';
            
            // Add random paragraphs
            $availableParagraphs = $contentParagraphs;
            shuffle($availableParagraphs);
            for ($p = 0; $p < $numParagraphs - 1; $p++) {
                $selectedParagraphs[] = $availableParagraphs[$p % count($availableParagraphs)];
            }
            
            $body = implode("\n\n", $selectedParagraphs);
            
            // Random status and dates
            $statuses = ['published', 'published', 'published', 'scheduled', 'pending'];
            $status = $statuses[array_rand($statuses)];
            
            $daysAgo = rand(1, 180);
            $publishedAt = $status === 'published' ? now()->subDays($daysAgo) : null;
            $scheduledFor = $status === 'scheduled' ? now()->addDays(rand(1, 30)) : null;
            
            // Random author
            $author = $users->random();
            
            // Create post
            $postId = DB::table('fblog_posts')->insertGetId([
                'title' => $title,
                'slug' => Str::slug($title) . '-' . $i,
                'sub_title' => $subTitle,
                'body' => $body,
                'status' => $status,
                'published_at' => $publishedAt,
                'scheduled_for' => $scheduledFor,
                'cover_photo_path' => 'https://picsum.photos/seed/' . $i . '/1200/630',
                'photo_alt_text' => $title,
                'user_id' => $author->id,
                'created_at' => now()->subDays($daysAgo + rand(1, 5)),
                'updated_at' => now()->subDays(rand(0, $daysAgo)),
            ]);
            
            // Attach 1-3 random categories
            $numCategories = rand(1, 3);
            $selectedCategories = array_rand(array_flip($categoryIds), $numCategories);
            if (!is_array($selectedCategories)) {
                $selectedCategories = [$selectedCategories];
            }
            
            foreach ($selectedCategories as $categoryId) {
                DB::table('fblog_category_fblog_post')->insert([
                    'post_id' => $postId,
                    'category_id' => $categoryId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            
            // Attach 2-5 random tags
            $numTags = rand(2, 5);
            $selectedTags = array_rand(array_flip($tagIds), $numTags);
            if (!is_array($selectedTags)) {
                $selectedTags = [$selectedTags];
            }
            
            foreach ($selectedTags as $tagId) {
                DB::table('fblog_post_fblog_tag')->insert([
                    'post_id' => $postId,
                    'tag_id' => $tagId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            
            // Create SEO details
            $keywords = [];
            foreach ($selectedTags as $tagId) {
                $tag = DB::table('fblog_tags')->where('id', $tagId)->first();
                $keywords[] = $tag->name;
            }
            
            DB::table('fblog_seo_details')->insert([
                'post_id' => $postId,
                'title' => $title . ' | Blog Desa',
                'keywords' => json_encode($keywords),
                'description' => Str::limit(strip_tags($body), 155),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->command->newLine(2);
        $this->command->info('✅ Berhasil membuat:');
        $this->command->info('   📁 ' . count($categories) . ' kategori');
        $this->command->info('   🏷️  ' . count($tags) . ' tags');
        $this->command->info('   📝 100 blog posts dengan konten lengkap');
        $this->command->info('   🔍 100 SEO details');
        $this->command->newLine();
        $this->command->info('🎉 Seeding selesai!');
    }
}

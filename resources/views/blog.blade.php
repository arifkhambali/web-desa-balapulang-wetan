@extends('layouts.app')

@section('title', 'Blog - ' . ($identitasDesa->nama_desa ?? 'Desa Tundagan'))

@section('content')
    {{-- Hero Section --}}
    <section class="relative pt-32 pb-20 bg-slate-50 dark:bg-slate-900 overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#3b82f6_1px,transparent_1px)] [background-size:16px_16px]"></div>
        
        <div class="container mx-auto px-4 relative z-10 text-center">
            <div class="max-w-3xl mx-auto">
                <span class="text-primary font-semibold tracking-wider uppercase text-sm animate-fade-in-up">Warta Desa</span>
                <h1 class="text-4xl md:text-6xl font-bold text-slate-800 dark:text-white mt-2 mb-6 animate-fade-in-up">
                    Kabar Desa
                </h1>
                <p class="text-lg md:text-xl text-slate-600 dark:text-slate-400 max-w-2xl mx-auto animate-fade-in-up [animation-delay:200ms]">
                    Baca artikel, berita terkini, dan cerita menarik dari {{ $identitasDesa->nama_desa ?? 'Desa Tundagan' }}.
                </p>
            </div>
        </div>
    </section>

    {{-- Main Content --}}
    <section class="py-16 bg-slate-50 dark:bg-slate-900 transition-colors duration-300">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-8">
                {{-- Main Content --}}
                <div class="flex-1">
                    {{-- Search & Filter Section --}}
                    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm mb-6">
                        <form method="GET" action="{{ route('blog') }}" class="space-y-4">
                            {{-- Search Bar --}}
                            <div>
                                <x-search-bar name="search" :value="request('search') ?? ''"
                                    placeholder="Cari artikel berdasarkan judul atau konten..." />
                            </div>

                            {{-- Filters Row --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-4">
                                {{-- Kategori Filter --}}
                                <div>
                                    <label
                                        class="block text-xs md:text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5 md:mb-2">
                                        <i class="fa-solid fa-folder mr-1"></i> Kategori
                                    </label>
                                    <select name="category"
                                        class="w-full px-3 md:px-4 py-2 md:py-2.5 text-sm md:text-base rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all">
                                        <option value="">Semua Kategori</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                                                {{ $cat->name }} ({{ $cat->posts_count }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Action Buttons --}}
                                <div class="flex items-end gap-2 md:gap-3">
                                    <button type="submit"
                                        class="px-4 md:px-6 py-2 md:py-2.5 bg-purple-600 hover:bg-purple-700 text-white text-sm md:text-base font-semibold rounded-lg shadow-sm transition-all flex items-center gap-2">
                                        <i class="fa-solid fa-filter text-xs md:text-sm"></i>
                                        <span>Filter</span>
                                    </button>
                                    <a href="{{ route('blog') }}"
                                        class="px-4 md:px-6 py-2 md:py-2.5 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 text-sm md:text-base font-semibold rounded-lg transition-all flex items-center gap-2">
                                        <i class="fa-solid fa-rotate-right text-xs md:text-sm"></i>
                                        <span>Reset</span>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Results Count --}}
                    @if(request()->hasAny(['search', 'category']))
                        <div class="mb-4 text-sm text-slate-600 dark:text-slate-400">
                            Menampilkan <strong class="text-slate-800 dark:text-white">{{ $posts->total() }}</strong> hasil
                        </div>
                    @endif

                    {{-- Blog Grid --}}
                    @if($posts->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($posts as $post)
                                <article data-blog-card
                                    class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden group">
                                    {{-- Featured Image --}}
                                    <a href="{{ route('blog.detail', $post->slug) }}" wire:navigate
                                        class="block relative h-48 overflow-hidden">
                                        @if($post->cover_photo_path)
                                            <img data-src="{{ Str::startsWith($post->cover_photo_path, 'http') ? $post->cover_photo_path : asset('storage/' . $post->cover_photo_path) }}"
                                                src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300'%3E%3C/svg%3E"
                                                alt="{{ $post->title }}"
                                                class="lazy-image w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        @else
                                            <div
                                                class="w-full h-full bg-gradient-to-br from-purple-400 to-pink-600 flex items-center justify-center">
                                                <i class="fa-solid fa-blog text-white text-4xl"></i>
                                            </div>
                                        @endif
                                        {{-- Category Badge --}}
                                        @if($post->categories->count() > 0)
                                            <div class="absolute top-3 left-3">
                                                <span
                                                    class="px-3 py-1 bg-purple-600 text-white text-xs font-semibold rounded-full">
                                                    {{ $post->categories->first()->name }}
                                                </span>
                                            </div>
                                        @endif
                                    </a>

                                    {{-- Content --}}
                                    <div class="p-5">
                                        {{-- Meta Info --}}
                                        <div class="flex items-center gap-3 text-xs text-slate-500 dark:text-slate-400 mb-3">
                                            <span><i
                                                    class="fa-regular fa-calendar mr-1"></i>{{ $post->published_at->format('d M Y') }}</span>
                                            <span><i class="fa-regular fa-user mr-1"></i>{{ $post->user->name }}</span>
                                        </div>

                                        {{-- Title --}}
                                        <h3 class="mb-2">
                                            <a href="{{ route('blog.detail', $post->slug) }}" wire:navigate
                                                class="text-lg font-bold text-slate-800 dark:text-white hover:text-purple-600 dark:hover:text-purple-400 transition-colors line-clamp-2">
                                                {{ $post->title }}
                                            </a>
                                        </h3>

                                        {{-- Excerpt --}}
                                        <p class="text-sm text-slate-600 dark:text-slate-400 line-clamp-3 mb-4">
                                            {{ $post->excerpt }}
                                        </p>

                                        {{-- Read More --}}
                                        <a href="{{ route('blog.detail', $post->slug) }}" wire:navigate
                                            class="inline-flex items-center gap-2 text-sm font-semibold text-purple-600 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-300 transition-colors">
                                            Baca Selengkapnya
                                            <i class="fa-solid fa-arrow-right text-xs"></i>
                                        </a>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        {{-- Pagination --}}
                        @if($posts->hasPages())
                            <div class="mt-8">
                                {{ $posts->links() }}
                            </div>
                        @endif
                    @else
                        {{-- Empty State --}}
                        <div class="col-span-full text-center py-16">
                            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-slate-100 dark:bg-slate-800 mb-4">
                                <i class="fa-solid fa-inbox text-3xl text-slate-400"></i>
                            </div>
                            <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-2">Tidak Ada Artikel</h3>
                            <p class="text-slate-600 dark:text-slate-400">
                                @if(request()->hasAny(['search', 'category']))
                                    Tidak ada artikel yang sesuai dengan pencarian Anda.
                                @else
                                    Belum ada artikel yang dipublikasikan.
                                @endif
                            </p>
                        </div>
                    @endif
                </div>

                {{-- Sidebar --}}
                <aside class="lg:w-80 space-y-6">
                    {{-- Categories --}}
                    @if($categories->count() > 0)
                        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm">
                            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-folder text-purple-500"></i> Kategori
                            </h3>
                            <div class="space-y-2">
                                @foreach($categories as $category)
                                    <a href="{{ route('blog', ['category' => $category->slug]) }}" wire:navigate
                                        class="flex items-center justify-between p-3 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors group">
                                        <span class="text-slate-700 dark:text-slate-300 group-hover:text-purple-600 transition-colors">
                                            {{ $category->name }}
                                        </span>
                                        <span class="bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 px-2 py-1 rounded-full text-xs font-semibold">
                                            {{ $category->posts_count }}
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Mini Gallery Sidebar --}}
                    @if($galleries->count() > 0)
                        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm">
                            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-images text-purple-500"></i> Galeri Terbaru
                            </h3>
                            <div class="grid grid-cols-2 gap-2">
                                @foreach($galleries->take(6) as $g)
                                    <div class="aspect-square rounded-lg overflow-hidden cursor-pointer" onclick="openGalleryModal('{{ Str::startsWith($g->gambar, 'http') ? $g->gambar : asset('storage/' . $g->gambar) }}', '{{ $g->judul }}', '{{ $g->kategori }}', '', '')">
                                        <img src="{{ Str::startsWith($g->gambar, 'http') ? $g->gambar : asset('storage/' . $g->gambar) }}" class="w-full h-full object-cover hover:scale-110 transition-transform duration-300">
                                    </div>
                                @endforeach
                            </div>
                            <a href="{{ route('galeri') }}" class="block text-center mt-4 text-sm font-semibold text-purple-600 hover:underline">Lihat Semua Galeri</a>
                        </div>
                    @endif
                </aside>
            </div>
        </div>
    </section>

    {{-- Modal Galeri (Include for consistency) --}}
    <div id="gallery-modal" onclick="if(event.target === this) closeGalleryModal()"
        class="fixed inset-0 z-[9999] bg-black/90 backdrop-blur-md hidden opacity-0 transition-opacity duration-300 flex items-center justify-center p-4">
        <button onclick="closeGalleryModal()" class="absolute top-6 right-6 text-white/70 hover:text-white z-50"><i class="fa-solid fa-xmark text-4xl"></i></button>
        <div class="relative w-full max-w-5xl bg-slate-900 rounded-3xl overflow-hidden shadow-2xl transform scale-95 transition-transform duration-300" id="gallery-modal-content">
            <div class="flex flex-col md:flex-row">
                <div class="w-full md:w-2/3 h-[40vh] md:h-[70vh] bg-black flex items-center justify-center"><img id="modal-image" src="" alt="" class="max-w-full max-h-full object-contain"></div>
                <div class="w-full md:w-1/3 bg-white dark:bg-slate-800 p-6 flex flex-col">
                    <span id="modal-category" class="inline-block px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-600 text-xs font-bold rounded-full mb-3 w-fit"></span>
                    <h2 id="modal-title" class="text-xl font-bold text-slate-800 dark:text-white mb-4"></h2>
                    <button onclick="closeGalleryModal()" class="mt-auto w-full py-3 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-xl font-semibold hover:bg-slate-200 transition-colors">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function openGalleryModal(imgSrc, title, category) {
            const modal = document.getElementById('gallery-modal');
            const content = document.getElementById('gallery-modal-content');
            document.getElementById('modal-image').src = imgSrc;
            document.getElementById('modal-title').textContent = title;
            document.getElementById('modal-category').textContent = category;
            modal.classList.remove('hidden');
            setTimeout(() => { modal.classList.remove('opacity-0'); content.classList.add('scale-100'); }, 10);
        }
        function closeGalleryModal() {
            const modal = document.getElementById('gallery-modal');
            modal.classList.add('opacity-0');
            setTimeout(() => { modal.classList.add('hidden'); }, 300);
        }
    </script>
    @endpush
@endsection

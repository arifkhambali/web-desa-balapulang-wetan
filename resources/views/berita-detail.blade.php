@extends('layouts.app')

@section('title', $berita->judul . ' - ' . ($identitasDesa->nama_desa ?? 'Desa Tundagan'))

@section('content')

    <section class="pt-24 pb-6 bg-slate-50 dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800">
        <div class="container mx-auto px-4">

        </div>
    </section>
    {{-- Main Content --}}
    <section class="py-12 bg-white dark:bg-dark transition-colors duration-300">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-8">
                {{-- Article Content --}}
                <article class="flex-1">
                    {{-- Category Badge --}}
                    <div class="mb-4">
                        <a href="{{ route('berita', ['kategori' => $berita->kategori_berita_id]) }}"
                            class="inline-block bg-primary text-white text-sm font-bold px-4 py-2 rounded-full hover:bg-blue-600 transition-colors">
                            {{ $berita->kategoriBerita->nama_kategori ?? 'Umum' }}
                        </a>
                    </div>

                    {{-- Title --}}
                    <h1
                        class="text-3xl md:text-4xl lg:text-5xl font-bold text-slate-800 dark:text-white mb-6 leading-tight">
                        {{ $berita->judul }}
                    </h1>

                    {{-- Meta Information --}}
                    <div
                        class="flex flex-wrap items-center gap-4 md:gap-6 text-slate-600 dark:text-slate-400 mb-8 pb-6 border-b border-slate-200 dark:border-slate-700">
                        <div class="flex items-center gap-2">
                            <i class="fa-regular fa-user"></i>
                            <span class="font-medium">{{ $berita->penulis }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa-regular fa-calendar"></i>
                            <span>{{ $berita->published_at->format('d F Y') }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa-regular fa-clock"></i>
                            <span>{{ $berita->published_at->format('H:i') }} WIB</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa-regular fa-eye"></i>
                            <span>{{ number_format($berita->views) }} views</span>
                        </div>
                    </div>

                    {{-- Featured Image --}}
                    @if($berita->gambar)
                        <div class="mb-8 rounded-2xl overflow-hidden shadow-lg">
                            <img data-src="{{ asset('storage/' . $berita->gambar) }}"
                                src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300'%3E%3C/svg%3E"
                                alt="{{ $berita->judul }}" class="lazy-image w-full h-auto">
                        </div>
                    @endif

                    {{-- Content --}}
                    <div class="prose prose-lg dark:prose-invert max-w-none mb-12">
                        {!! $berita->konten !!}
                    </div>

                    {{-- Share Buttons --}}
                    <div class="bg-slate-50 dark:bg-slate-800 rounded-2xl p-6 mb-8">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4">Bagikan Artikel</h3>
                        <div class="flex flex-wrap gap-3">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                                target="_blank"
                                class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                <i class="fa-brands fa-facebook-f"></i>
                                <span>Facebook</span>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($berita->judul) }}"
                                target="_blank"
                                class="flex items-center gap-2 bg-sky-500 text-white px-4 py-2 rounded-lg hover:bg-sky-600 transition-colors">
                                <i class="fa-brands fa-twitter"></i>
                                <span>Twitter</span>
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($berita->judul . ' - ' . request()->url()) }}"
                                target="_blank"
                                class="flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                                <i class="fa-brands fa-whatsapp"></i>
                                <span>WhatsApp</span>
                            </a>
                            <button onclick="copyToClipboard('{{ request()->url() }}')"
                                class="flex items-center gap-2 bg-slate-600 text-white px-4 py-2 rounded-lg hover:bg-slate-700 transition-colors">
                                <i class="fa-solid fa-link"></i>
                                <span>Salin Link</span>
                            </button>
                        </div>
                    </div>

                    {{-- Navigation --}}
                    <div class="flex items-center justify-between pt-6 border-t border-slate-200 dark:border-slate-700">
                        <a href="{{ route('berita') }}"
                            class="inline-flex items-center gap-2 text-primary font-semibold hover:underline">
                            <i class="fa-solid fa-arrow-left"></i>
                            <span>Kembali ke Berita</span>
                        </a>
                    </div>
                </article>

                {{-- Sidebar --}}
                <aside class="lg:w-80 space-y-6">
                    {{-- Berita Terkait --}}
                    @if($beritaTerkait->count() > 0)
                        <div class="bg-slate-50 dark:bg-slate-800 rounded-2xl p-6 shadow-sm">
                            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-layer-group text-primary"></i> Berita Terkait
                            </h3>
                            <div class="space-y-4">
                                @foreach($beritaTerkait as $terkait)
                                    <a href="{{ route('berita.detail', $terkait->slug) }}" wire:navigate class="flex gap-3 group">
                                        <div class="relative w-20 h-20 flex-shrink-0 rounded-lg overflow-hidden">
                                            @if($terkait->gambar)
                                                <img data-src="{{ asset('storage/' . $terkait->gambar) }}"
                                                    src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300'%3E%3C/svg%3E"
                                                    alt="{{ $terkait->judul }}"
                                                    class="lazy-image w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                            @else
                                                <div
                                                    class="w-full h-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                                                    <i class="fa-solid fa-newspaper text-white text-xl"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4
                                                class="font-semibold text-slate-800 dark:text-white text-sm line-clamp-2 group-hover:text-primary transition-colors mb-1">
                                                {{ $terkait->judul }}
                                            </h4>
                                            <div class="flex items-center gap-3 text-xs text-slate-500 dark:text-slate-400">
                                                <span><i
                                                        class="fa-regular fa-calendar mr-1"></i>{{ $terkait->published_at->format('d M Y') }}</span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Berita Terpopuler --}}
                    @if($beritaTerpopuler->count() > 0)
                        <div class="bg-slate-50 dark:bg-slate-800 rounded-2xl p-6 shadow-sm">
                            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-fire text-orange-500"></i> Terpopuler
                            </h3>
                            <div class="space-y-4">
                                @foreach($beritaTerpopuler as $popular)
                                    <a href="{{ route('berita.detail', $popular->slug) }}" wire:navigate class="flex gap-3 group">
                                        <div class="relative w-20 h-20 flex-shrink-0 rounded-lg overflow-hidden">
                                            @if($popular->gambar)
                                                <img data-src="{{ asset('storage/' . $popular->gambar) }}"
                                                    src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300'%3E%3C/svg%3E"
                                                    alt="{{ $popular->judul }}"
                                                    class="lazy-image w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                            @else
                                                <div
                                                    class="w-full h-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                                                    <i class="fa-solid fa-newspaper text-white text-xl"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4
                                                class="font-semibold text-slate-800 dark:text-white text-sm line-clamp-2 group-hover:text-primary transition-colors mb-1">
                                                {{ $popular->judul }}
                                            </h4>
                                            <div class="flex items-center gap-3 text-xs text-slate-500 dark:text-slate-400">
                                                <span><i
                                                        class="fa-regular fa-eye mr-1"></i>{{ number_format($popular->views) }}</span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Kategori --}}
                    @if($kategoriList->count() > 0)
                        <div class="bg-slate-50 dark:bg-slate-800 rounded-2xl p-6 shadow-sm">
                            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-folder text-blue-500"></i> Kategori
                            </h3>
                            <div class="space-y-2">
                                @foreach($kategoriList as $kategori)
                                    <a href="{{ route('berita', ['kategori' => $kategori->id]) }}" wire:navigate
                                        class="flex items-center justify-between p-3 rounded-lg hover:bg-white dark:hover:bg-slate-700 transition-colors group">
                                        <span
                                            class="text-slate-700 dark:text-slate-300 group-hover:text-primary transition-colors text-sm">
                                            {{ $kategori->nama_kategori }}
                                        </span>
                                        <span class="bg-primary/10 text-primary px-2 py-1 rounded-full text-xs font-semibold">
                                            {{ $kategori->beritas_count }}
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </aside>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            function copyToClipboard(text) {
                navigator.clipboard.writeText(text).then(function () {
                    alert('Link berhasil disalin!');
                }, function (err) {
                    console.error('Gagal menyalin link: ', err);
                });
            }
        </script>
    @endpush
@endsection
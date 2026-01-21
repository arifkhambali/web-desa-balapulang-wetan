{{-- Metadata untuk AJAX --}}
<div id="pagination-metadata" data-total="{{ $beritas->total() }}"
    data-has-more="{{ $beritas->hasMorePages() ? 'true' : 'false' }}" data-next-page="{{ $beritas->nextPageUrl() }}"
    class="hidden">
</div>
@forelse($beritas as $berita)
    <article data-berita-card
        class="bg-white dark:bg-slate-800 rounded-xl md:rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group">
        <a href="{{ route('berita.detail', $berita->slug) }}" wire:navigate>
            <div class="relative h-32 sm:h-40 md:h-48 overflow-hidden">
                @if($berita->gambar)
                    <img data-src="{{ asset('storage/' . $berita->gambar) }}"
                        src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300'%3E%3C/svg%3E"
                        alt="{{ $berita->judul }}"
                        class="lazy-image w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                        <i class="fa-solid fa-newspaper text-white text-3xl md:text-5xl"></i>
                    </div>
                @endif
                <div
                    class="absolute top-2 left-2 md:top-4 md:left-4 bg-primary text-white text-xs font-bold px-2 py-0.5 md:px-3 md:py-1 rounded-full">
                    {{ $berita->kategori ?? 'Umum' }}
                </div>
            </div>
        </a>
        <div class="p-3 sm:p-4 md:p-6">
            <div class="flex items-center text-xs text-slate-500 dark:text-slate-400 mb-2 md:mb-3 gap-3 md:gap-4">
                <span><i class="fa-regular fa-calendar mr-1"></i> {{ $berita->published_at->format('d M Y') }}</span>
                <span><i class="fa-regular fa-eye mr-1"></i> {{ number_format($berita->views) }}</span>
            </div>
            <a href="{{ route('berita.detail', $berita->slug) }}" wire:navigate>
                <h3
                    class="text-base sm:text-lg md:text-xl font-bold text-slate-800 dark:text-white mb-2 md:mb-3 group-hover:text-primary transition-colors line-clamp-2">
                    {{ $berita->judul }}
                </h3>
            </a>
            <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm line-clamp-2 md:line-clamp-3 mb-3 md:mb-4">
                {{ strip_tags($berita->konten) }}
            </p>
            <div class="flex items-center justify-between">
                <span class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 truncate">
                    <i class="fa-regular fa-user mr-1"></i> {{ $berita->penulis }}
                </span>
                <a href="{{ route('berita.detail', $berita->slug) }}" wire:navigate
                    class="text-primary font-semibold hover:underline text-xs sm:text-sm whitespace-nowrap ml-2">
                    Baca <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </article>
@empty
    <div class="col-span-full text-center py-16 md:py-20">
        <div
            class="w-20 h-20 md:w-24 md:h-24 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fa-solid fa-search text-slate-400 text-4xl md:text-5xl"></i>
        </div>
        <h3 class="text-lg md:text-xl font-bold text-slate-700 dark:text-slate-300 mb-2">Tidak Ada Hasil Ditemukan</h3>
        <p class="text-slate-500 dark:text-slate-400 text-sm md:text-base mb-4 max-w-md mx-auto px-4">
            Maaf, kami tidak menemukan berita yang sesuai dengan pencarian Anda.
        </p>
        <div class="text-slate-600 dark:text-slate-400 text-xs md:text-sm space-y-1">
            <p>💡 <strong>Saran:</strong></p>
            <ul class="list-none space-y-1 mt-2">
                <li>• Coba gunakan kata kunci yang berbeda</li>
                <li>• Periksa ejaan kata kunci</li>
                <li>• Gunakan kata kunci yang lebih umum</li>
                <li>• Hapus beberapa filter untuk hasil lebih luas</li>
            </ul>
        </div>
    </div>
@endforelse
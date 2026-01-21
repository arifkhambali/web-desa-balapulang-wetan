{{-- Metadata untuk AJAX --}}
<div id="gallery-metadata" data-total="{{ $galleries->total() }}" data-next-page="{{ $galleries->nextPageUrl() }}"
    class="hidden">
</div>

@forelse($galleries as $gallery)
    <div data-gallery-item
        onclick="openGalleryModal('{{ asset('storage/' . $gallery->gambar) }}', '{{ $gallery->judul }}', '{{ $gallery->kategori }}', '{{ $gallery->tanggal_kegiatan ? $gallery->tanggal_kegiatan->format('d M Y') : '' }}', `{{ $gallery->deskripsi }}`)"
        class="group relative rounded-2xl overflow-hidden bg-slate-100 dark:bg-slate-800 cursor-pointer hover:shadow-xl transition-all duration-300 hover:-translate-y-1 h-full">
        {{-- Aspect Ratio Container --}}
        <div class="aspect-[4/3] overflow-hidden relative">
            <img data-src="{{ asset('storage/' . $gallery->gambar) }}"
                src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300'%3E%3C/svg%3E"
                alt="{{ $gallery->judul }}"
                class="lazy-image w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-110">

            {{-- Overlay --}}
            <div
                class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-6">
                <span
                    class="inline-block px-3 py-1 bg-primary/90 text-white text-xs font-bold rounded-full w-fit mb-2 backdrop-blur-sm">
                    {{ $gallery->kategori }}
                </span>
                <h3 class="text-white font-bold text-lg leading-tight mb-1 line-clamp-2">{{ $gallery->judul }}</h3>
                @if($gallery->tanggal_kegiatan)
                    <p class="text-slate-300 text-xs"><i class="fa-regular fa-calendar mr-1"></i>
                        {{ $gallery->tanggal_kegiatan->format('d M Y') }}</p>
                @endif
            </div>
        </div>
    </div>
@empty
    <div class="col-span-full text-center py-20">
        <div
            class="w-20 h-20 md:w-24 md:h-24 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fa-solid fa-search text-slate-400 text-4xl md:text-5xl"></i>
        </div>
        <h3 class="text-lg md:text-xl font-bold text-slate-700 dark:text-slate-300 mb-2">Tidak Ada Foto Ditemukan</h3>
        <p class="text-slate-500 dark:text-slate-400 text-sm md:text-base mb-4 max-w-md mx-auto px-4">
            Maaf, kami tidak menemukan foto yang sesuai dengan pencarian Anda.
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
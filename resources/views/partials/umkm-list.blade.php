{{-- Metadata untuk AJAX --}}
<div id="pagination-metadata" data-total="{{ $products->total() }}"
    data-has-more="{{ $products->hasMorePages() ? 'true' : 'false' }}" data-next-page="{{ $products->nextPageUrl() }}"
    class="hidden">
</div>
@forelse($products as $product)
    <div data-product-card
        class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden group hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
        <a href="{{ route('umkm.detail', $product->slug) }}" wire:navigate>
            <div class="relative aspect-square overflow-hidden">
                @if($product->gambar)
                    <img data-src="{{ asset('storage/' . $product->gambar) }}"
                        src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300'%3E%3C/svg%3E"
                        alt="{{ $product->nama_produk }}"
                        class="lazy-image w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center">
                        <i class="fa-solid fa-box text-white text-5xl"></i>
                    </div>
                @endif
                @if($product->featured)
                    <div
                        class="absolute top-3 left-3 bg-yellow-500 text-white px-2 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                        <i class="fa-solid fa-star"></i> Unggulan
                    </div>
                @endif
            </div>
        </a>
        <div class="p-4">
            <div class="text-xs text-slate-500 dark:text-slate-400 mb-1">
                {{ $product->kategori ?? 'Umum' }}
            </div>
            <a href="{{ route('umkm.detail', $product->slug) }}" wire:navigate>
                <h3
                    class="text-base font-bold text-slate-800 dark:text-white mb-2 line-clamp-2 hover:text-primary transition-colors">
                    {{ $product->nama_produk }}
                </h3>
            </a>
            <div class="mb-3">
                <span class="text-lg font-bold text-primary">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
            </div>
            <div class="flex items-center gap-2 mb-3">
                <span class="text-sm text-slate-600 dark:text-slate-300">{{ $product->nama_penjual }}</span>
            </div>
            <a href="{{ route('umkm.detail', $product->slug) }}" wire:navigate
                class="w-full py-2 rounded-xl bg-primary text-white font-semibold hover:bg-blue-600 transition-colors flex items-center justify-center gap-2 text-sm">
                <i class="fa-solid fa-eye"></i> Lihat Detail
            </a>
        </div>
    </div>
@empty
    <div class="col-span-full text-center py-16 md:py-20">
        <div
            class="w-20 h-20 md:w-24 md:h-24 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fa-solid fa-search text-slate-400 text-4xl md:text-5xl"></i>
        </div>
        <h3 class="text-lg md:text-xl font-bold text-slate-700 dark:text-slate-300 mb-2">Tidak Ada Produk Ditemukan</h3>
        <p class="text-slate-500 dark:text-slate-400 text-sm md:text-base mb-4 max-w-md mx-auto px-4">
            Maaf, kami tidak menemukan produk yang sesuai dengan pencarian Anda.
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
@extends('layouts.app')

@section('title', $product->nama_produk . ' - UMKM ' . ($identitasDesa->nama_desa ?? 'Desa Tundagan'))

@section('content')
<!-- Product Detail Section -->
<section class="py-20 pt-32 bg-white dark:bg-dark transition-colors duration-300">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
            <!-- Product Image -->
            <div class="space-y-4">
                <div class="aspect-square rounded-2xl overflow-hidden bg-slate-100 dark:bg-slate-800">
                    @if($product->gambar)
                    <img data-src="{{ asset('storage/' . $product->gambar) }}" 
                         src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300'%3E%3C/svg%3E"
                         alt="{{ $product->nama_produk }}"
                         class="lazy-image w-full h-full object-cover">
                    @else
                    <div
                        class="w-full h-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center">
                        <i class="fa-solid fa-box text-white text-9xl"></i>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Product Info -->
            <div class="space-y-6">
                <!-- Breadcrumb -->
                <nav class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                    <a href="{{ route('home') }}" wire:navigate
                        class="hover:text-primary transition-colors">Beranda</a>
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                    <a href="{{ route('umkm') }}" wire:navigate class="hover:text-primary transition-colors">UMKM</a>
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                    <span class="text-slate-800 dark:text-white">{{ $product->nama_produk }}</span>
                </nav>

                <!-- Category Badge -->
                <div>
                    <span
                        class="inline-block px-3 py-1 bg-primary/10 text-primary rounded-full text-sm font-semibold">
                        {{ $product->kategoriUmkm->nama_kategori ?? 'Umum' }}
                    </span>
                    @if($product->featured)
                    <span
                        class="inline-block px-3 py-1 bg-yellow-500 text-white rounded-full text-sm font-semibold ml-2">
                        <i class="fa-solid fa-star"></i> Produk Unggulan
                    </span>
                    @endif
                </div>

                <!-- Product Name -->
                <h1 class="text-3xl md:text-4xl font-bold text-slate-800 dark:text-white">
                    {{ $product->nama_produk }}
                </h1>

                <!-- Price -->
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-bold text-primary">Rp
                        {{ number_format($product->harga, 0, ',', '.') }}</span>
                </div>

                <!-- Stock & Status -->
                <div class="flex items-center gap-4 flex-wrap">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-box text-slate-600 dark:text-slate-400"></i>
                        <span class="text-slate-600 dark:text-slate-400">Stok: <span
                                class="font-semibold text-slate-800 dark:text-white">{{ $product->stok }}</span></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-eye text-slate-600 dark:text-slate-400"></i>
                        <span class="text-slate-600 dark:text-slate-400">Dilihat: <span
                                class="font-semibold text-slate-800 dark:text-white">{{ number_format($product->views) }}x</span></span>
                    </div>
                    <div class="flex items-center gap-2">
                        @if($product->status === 'tersedia')
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold">
                            <i class="fa-solid fa-check-circle"></i> Tersedia
                        </span>
                        @elseif($product->status === 'habis')
                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-semibold">
                            <i class="fa-solid fa-times-circle"></i> Habis
                        </span>
                        @endif
                    </div>
                </div>

                <!-- Description -->
                <div class="border-t border-slate-200 dark:border-slate-700 pt-6">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-3">Deskripsi Produk</h3>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed whitespace-pre-line">
                        {{ $product->deskripsi }}
                    </p>
                </div>

                <!-- Seller Info -->
                <div class="border-t border-slate-200 dark:border-slate-700 pt-6">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-3">Informasi Penjual</h3>
                    <div class="flex items-center gap-3 mb-4">
                        <div
                            class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center text-primary">
                            <i class="fa-solid fa-user text-xl"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-slate-800 dark:text-white">{{ $product->nama_penjual }}</p>
                            <p class="text-sm text-slate-600 dark:text-slate-400">Penjual UMKM</p>
                        </div>
                    </div>
                </div>

                <!-- Order Button -->
                <div class="border-t border-slate-200 dark:border-slate-700 pt-6">
                    <a href="https://wa.me/{{ $product->kontak }}?text=Halo, saya tertarik dengan produk {{ $product->nama_produk }}"
                        target="_blank"
                        class="w-full py-4 px-6 bg-green-600 hover:bg-green-700 text-white rounded-xl font-bold text-lg flex items-center justify-center gap-3 transition-all hover:scale-105 shadow-lg">
                        <i class="fa-brands fa-whatsapp text-2xl"></i>
                        <span>Pesan via WhatsApp</span>
                    </a>
                    <p class="text-sm text-slate-500 dark:text-slate-400 text-center mt-3">
                        Klik tombol di atas untuk langsung chat dengan penjual
                    </p>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
        <div class="border-t border-slate-200 dark:border-slate-700 pt-16">
            <h2 class="text-2xl md:text-3xl font-bold text-slate-800 dark:text-white mb-8">Produk Terkait</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                <a href="{{ route('umkm.detail', $related->slug) }}" wire:navigate
                    class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden group hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                    <div class="relative aspect-square overflow-hidden">
                        @if($related->gambar)
                        <img data-src="{{ asset('storage/' . $related->gambar) }}" 
                             src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300'%3E%3C/svg%3E"
                             alt="{{ $related->nama_produk }}"
                             class="lazy-image w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        @else
                        <div
                            class="w-full h-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center">
                            <i class="fa-solid fa-box text-white text-4xl"></i>
                        </div>
                        @endif
                        <div
                            class="absolute top-3 right-3 bg-white/90 dark:bg-black/80 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-primary">
                            Rp {{ number_format($related->harga, 0, ',', '.') }}</div>
                    </div>
                    <div class="p-4">
                        <div class="text-xs text-slate-500 dark:text-slate-400 mb-1">
                            {{ $related->kategoriUmkm->nama_kategori ?? 'Umum' }}</div>
                        <h3 class="text-base font-bold text-slate-800 dark:text-white mb-2 line-clamp-2">
                            {{ $related->nama_produk }}</h3>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

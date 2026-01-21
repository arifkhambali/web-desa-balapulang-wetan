@extends('layouts.app')

@section('title', 'Layanan Publik - ' . ($identitasDesa->nama_desa ?? 'Desa Tundagan'))

@section('content')
<!-- Hero Section -->
<section class="relative pt-32 pb-20 bg-slate-900 overflow-hidden">
    <div class="absolute inset-0">
        <img src="{{ $identitasDesa->hero_image_layanan ? asset('storage/' . $identitasDesa->hero_image_layanan) : 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80' }}"
            alt="Layanan Desa" class="w-full h-full object-cover opacity-30">
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/80 via-slate-900/60 to-slate-50 dark:to-slate-900"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10 text-center">
        <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 animate-fade-in-up">
            Layanan Publik Online
        </h1>
        <p class="text-lg md:text-xl text-slate-300 max-w-2xl mx-auto animate-fade-in-up [animation-delay:200ms]">
            Akses mudah berbagai layanan administrasi {{ $identitasDesa->nama_desa ?? 'Desa Tundagan' }} secara online, cepat, dan transparan.
        </p>
    </div>
</section>

<!-- Featured Service: Pengajuan Surat -->
<section class="py-20 bg-white dark:bg-slate-900 transition-colors duration-300">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            <div class="bg-gradient-to-r from-blue-600 to-cyan-600 rounded-3xl shadow-2xl overflow-hidden transform hover:scale-[1.01] transition-transform duration-300">
                <div class="grid md:grid-cols-2 gap-8 items-center p-8 md:p-12">
                    <div class="text-white">
                        <div class="inline-block px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-semibold mb-4">
                            <i class="fa-solid fa-star text-yellow-300 mr-2"></i>Layanan Unggulan
                        </div>
                        <h2 class="text-3xl md:text-4xl font-bold mb-4">Pengajuan Surat Online</h2>
                        <p class="text-blue-100 mb-6 text-lg">
                            Ajukan berbagai jenis surat keterangan secara online tanpa perlu datang ke kantor desa. Silahkan login ke panel warga untuk memulai pengajuan.
                        </p>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center gap-3">
                                <i class="fa-solid fa-check-circle text-green-300 text-xl"></i>
                                <span>Proses 100% Online</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <i class="fa-solid fa-check-circle text-green-300 text-xl"></i>
                                <span>Tracking Status Real-time</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <i class="fa-solid fa-check-circle text-green-300 text-xl"></i>
                                <span>Notifikasi Email</span>
                            </li>
                        </ul>
                        <a href="{{ route('login') }}" wire:navigate class="inline-flex items-center gap-3 bg-white text-blue-600 px-8 py-4 rounded-full font-bold text-lg hover:bg-blue-50 transition-all hover:scale-105 shadow-lg">
                            <i class="fa-solid fa-right-to-bracket text-2xl"></i>
                            <span>Login Warga & Ajukan Surat</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="hidden md:block">
                        <div class="relative">
                            <div class="absolute inset-0 bg-white/10 backdrop-blur-sm rounded-2xl transform rotate-6"></div>
                            <div class="relative bg-white rounded-2xl p-8 shadow-2xl">
                                <div class="space-y-4">
                                    <div class="flex items-center gap-4 p-4 bg-blue-50 rounded-xl">
                                        <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white">
                                            <i class="fa-solid fa-file-lines text-xl"></i>
                                        </div>
                                        <div class="flex-1">
                                            <div class="font-semibold text-slate-800">Surat Keterangan</div>
                                            <div class="text-sm text-slate-500">Domisili, Usaha, dll</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4 p-4 bg-green-50 rounded-xl">
                                        <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center text-white">
                                            <i class="fa-solid fa-hand-holding-heart text-xl"></i>
                                        </div>
                                        <div class="flex-1">
                                            <div class="font-semibold text-slate-800">SKTM</div>
                                            <div class="text-sm text-slate-500">Tidak Mampu</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4 p-4 bg-orange-50 rounded-xl">
                                        <div class="w-12 h-12 bg-orange-600 rounded-full flex items-center justify-center text-white">
                                            <i class="fa-solid fa-users text-xl"></i>
                                        </div>
                                        <div class="flex-1">
                                            <div class="font-semibold text-slate-800">Surat Pengantar</div>
                                            <div class="text-sm text-slate-500">Berbagai Keperluan</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Other Services Grid -->
<section class="py-20 bg-slate-50 dark:bg-slate-800/50 transition-colors duration-300">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <span class="text-primary font-semibold tracking-wider uppercase text-sm">Kategori Layanan</span>
            <h2 class="text-3xl md:text-4xl font-bold text-slate-800 dark:text-white mt-2 mb-4">Daftar Layanan Tersedia</h2>
            <div class="w-20 h-1.5 bg-primary mx-auto rounded-full"></div>
            <p class="text-slate-600 dark:text-slate-400 mt-4 max-w-2xl mx-auto">
                Pilih layanan yang Anda butuhkan. Anda akan diarahkan untuk login ke panel warga terlebih dahulu.
            </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 max-w-6xl mx-auto">
            <!-- Layanan Items -->
            @foreach($jenisSurat as $surat)
            <a href="{{ route('login') }}" wire:navigate
                class="group bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col items-center text-center border border-slate-100 dark:border-slate-700">
                <div class="w-20 h-20 bg-{{ $surat->display_color }}-50 dark:bg-{{ $surat->display_color }}-900/20 text-{{ $surat->display_color }}-600 rounded-2xl flex items-center justify-center text-3xl mb-6 group-hover:bg-{{ $surat->display_color }}-600 group-hover:text-white transition-colors duration-300">
                    <i class="fa-solid {{ $surat->display_icon }}"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-2 group-hover:text-{{ $surat->display_color }}-600 dark:group-hover:text-{{ $surat->display_color }}-400 transition-colors">
                    {{ $surat->nama_surat }}
                </h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm mb-6 line-clamp-2">
                    {{ $surat->deskripsi ?? 'Layanan pengajuan surat keterangan secara online.' }}
                </p>
                <span class="mt-auto text-sm font-semibold text-{{ $surat->display_color }}-600 flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    Ajukan Sekarang <i class="fa-solid fa-arrow-right"></i>
                </span>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endsection

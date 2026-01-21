@extends('layouts.app')

@section('title', 'Pemerintahan Desa - ' . ($identitasDesa->nama_desa ?? 'Desa Tundagan'))

@section('content')
<!-- Hero Section -->
<section class="relative pt-32 pb-20 bg-slate-50 dark:bg-slate-900 overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#3b82f6_1px,transparent_1px)] [background-size:16px_16px]"></div>

    <div class="container mx-auto px-4 relative z-10 text-center">
        <span class="text-primary font-semibold tracking-wider uppercase text-sm animate-fade-in-up">Struktur Organisasi</span>
        <h1 class="text-4xl md:text-6xl font-bold text-slate-800 dark:text-white mt-2 mb-6 animate-fade-in-up">
            Pemerintahan Desa
        </h1>
        <p class="text-lg md:text-xl text-slate-600 dark:text-slate-400 max-w-2xl mx-auto animate-fade-in-up [animation-delay:200ms]">
            Mengenal jajaran aparatur {{ $identitasDesa->nama_desa ?? 'Desa Tundagan' }} yang berdedikasi melayani masyarakat dengan integritas dan profesionalisme.
        </p>
    </div>
</section>

<!-- Struktur Organisasi Section -->
<section class="py-20 bg-slate-50 dark:bg-slate-900 transition-colors duration-300">
    <div class="container mx-auto px-4">
        <!-- Kepala Desa (Top Level) -->
        @php
            $kades = $aparaturDesa->where('jabatan', 'Kepala Desa')->first();
            $sekdes = $aparaturDesa->where('jabatan', 'Sekretaris Desa')->first();
            $others = $aparaturDesa->whereNotIn('jabatan', ['Kepala Desa', 'Sekretaris Desa']);
        @endphp

        @if($kades)
        <div class="flex justify-center mb-16">
            <div class="w-full max-w-md">
                <a href="{{ route('aparatur.detail', $kades->slug) }}" class="block group bg-white dark:bg-slate-800 rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border-2 border-primary/10 dark:border-primary/20 text-center relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-2 bg-primary"></div>
                    <div class="relative w-48 h-48 mx-auto mb-8">
                        <div class="absolute inset-0 bg-blue-100 dark:bg-blue-900/30 rounded-full transform rotate-6 group-hover:rotate-12 transition-transform duration-300"></div>
                        @if($kades->foto)
                        <img data-src="{{ asset('storage/' . $kades->foto) }}" 
                            src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300'%3E%3C/svg%3E"
                            alt="{{ $kades->nama }}"
                            class="lazy-image relative w-full h-full object-cover rounded-full border-4 border-white dark:border-slate-700 shadow-xl">
                        @else
                        <img data-src="https://ui-avatars.com/api/?name={{ urlencode($kades->nama) }}&color=7F9CF5&background=EBF4FF" 
                            src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300'%3E%3C/svg%3E"
                            alt="{{ $kades->nama }}"
                            class="lazy-image relative w-full h-full object-cover rounded-full border-4 border-white dark:border-slate-700 shadow-xl">
                        @endif
                        <div class="absolute bottom-2 right-2 bg-primary text-white w-10 h-10 rounded-full flex items-center justify-center border-4 border-white dark:border-slate-700 shadow-md" title="Kepala Desa">
                            <i class="fa-solid fa-crown text-sm"></i>
                        </div>
                    </div>
                    
                    <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-2 group-hover:text-primary transition-colors">{{ $kades->nama }}</h3>
                    <p class="text-primary font-bold text-lg mb-4 uppercase tracking-wider">{{ $kades->jabatan }}</p>
                    
                    @if($kades->nip)
                    <div class="inline-block bg-slate-100 dark:bg-slate-700/50 px-4 py-2 rounded-full mb-6">
                        <p class="text-sm text-slate-600 dark:text-slate-400 font-mono">NIP: {{ $kades->nip }}</p>
                    </div>
                    @endif

                    <div class="grid grid-cols-1 gap-3 text-left bg-slate-50 dark:bg-slate-700/30 p-4 rounded-xl">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-calendar-days text-sm"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 dark:text-slate-400">Masa Jabatan</p>
                                <p class="text-sm font-medium text-slate-700 dark:text-slate-300">
                                    {{ $kades->tanggal_mulai_jabatan ? $kades->tanggal_mulai_jabatan->format('Y') : '-' }} - 
                                    {{ $kades->tanggal_selesai_jabatan ? $kades->tanggal_selesai_jabatan->format('Y') : 'Sekarang' }}
                                </p>
                            </div>
                        </div>
                        @if($kades->alamat)
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-location-dot text-sm"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 dark:text-slate-400">Alamat</p>
                                <p class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $kades->alamat }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="mt-6 text-primary font-semibold opacity-0 group-hover:opacity-100 transition-opacity">
                        Lihat Profil <i class="fa-solid fa-arrow-right ml-1"></i>
                    </div>
                </a>
            </div>
        </div>
        
        <!-- Connecting Line -->
        <div class="relative h-16 mb-16 hidden md:block">
            <div class="absolute left-1/2 top-0 bottom-0 w-0.5 bg-slate-200 dark:bg-slate-700 transform -translate-x-1/2"></div>
            <div class="absolute bottom-0 left-1/4 right-1/4 h-0.5 bg-slate-200 dark:bg-slate-700"></div>
            <div class="absolute bottom-0 left-1/4 w-0.5 h-4 bg-slate-200 dark:bg-slate-700 transform translate-y-full"></div>
            <div class="absolute bottom-0 right-1/4 w-0.5 h-4 bg-slate-200 dark:bg-slate-700 transform translate-y-full"></div>
        </div>
        @endif

        <!-- Sekretaris & Others Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @if($sekdes)
            <div class="relative group bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 dark:border-slate-700 text-center hover:-translate-y-2">
                <a href="{{ route('aparatur.detail', $sekdes->slug) }}" class="absolute inset-0 z-0"></a>
                <div class="relative w-32 h-32 mx-auto mb-6 pointer-events-none">
                    <div class="absolute inset-0 bg-blue-100 dark:bg-blue-900/30 rounded-full transform rotate-6 group-hover:rotate-12 transition-transform duration-300"></div>
                    @if($sekdes->foto)
                    <img data-src="{{ asset('storage/' . $sekdes->foto) }}" 
                        src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300'%3E%3C/svg%3E"
                        alt="{{ $sekdes->nama }}"
                        class="lazy-image relative w-full h-full object-cover rounded-full border-4 border-white dark:border-slate-700 shadow-md">
                    @else
                    <img data-src="https://ui-avatars.com/api/?name={{ urlencode($sekdes->nama) }}&color=7F9CF5&background=EBF4FF" 
                        src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300'%3E%3C/svg%3E"
                        alt="{{ $sekdes->nama }}"
                        class="lazy-image relative w-full h-full object-cover rounded-full border-4 border-white dark:border-slate-700 shadow-md">
                    @endif
                    <div class="absolute bottom-0 right-0 bg-blue-500 text-white w-8 h-8 rounded-full flex items-center justify-center border-2 border-white dark:border-slate-700 shadow-sm">
                        <i class="fa-solid fa-user-pen text-xs"></i>
                    </div>
                </div>
                
                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-1 group-hover:text-primary transition-colors pointer-events-none">{{ $sekdes->nama }}</h3>
                <p class="text-primary font-medium mb-2 pointer-events-none">{{ $sekdes->jabatan }}</p>
                @if($sekdes->nip)
                <p class="text-xs text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-700/50 py-1 px-3 rounded-full inline-block mb-4 pointer-events-none">
                    NIP: {{ $sekdes->nip }}
                </p>
                @endif

                <div class="flex justify-center gap-3 relative z-10">
                    @if($sekdes->telepon)
                    <a href="https://wa.me/{{ $sekdes->telepon }}" target="_blank" class="w-8 h-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center hover:bg-green-600 hover:text-white transition-colors">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                    @endif
                    @if($sekdes->email)
                    <a href="mailto:{{ $sekdes->email }}" class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-colors">
                        <i class="fa-regular fa-envelope"></i>
                    </a>
                    @endif
                </div>
                <div class="mt-4 text-primary font-semibold text-sm transition-opacity pointer-events-none">
                    Lihat Profil <i class="fa-solid fa-arrow-right ml-1"></i>
                </div>
            </div>
            @endif

            @foreach($others as $aparatur)
            <div class="relative group bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 dark:border-slate-700 text-center hover:-translate-y-2">
                <a href="{{ route('aparatur.detail', $aparatur->slug) }}" class="absolute inset-0 z-0"></a>
                <div class="relative w-32 h-32 mx-auto mb-6 pointer-events-none">
                    <div class="absolute inset-0 bg-slate-100 dark:bg-slate-700/30 rounded-full transform rotate-6 group-hover:rotate-12 transition-transform duration-300"></div>
                    @if($aparatur->foto)
                    <img data-src="{{ asset('storage/' . $aparatur->foto) }}" 
                        src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300'%3E%3C/svg%3E"
                        alt="{{ $aparatur->nama }}"
                        class="lazy-image relative w-full h-full object-cover rounded-full border-4 border-white dark:border-slate-700 shadow-md">
                    @else
                    <img data-src="https://ui-avatars.com/api/?name={{ urlencode($aparatur->nama) }}&color=7F9CF5&background=EBF4FF" 
                        src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300'%3E%3C/svg%3E"
                        alt="{{ $aparatur->nama }}"
                        class="lazy-image relative w-full h-full object-cover rounded-full border-4 border-white dark:border-slate-700 shadow-md">
                    @endif
                    <div class="absolute bottom-0 right-0 bg-slate-500 text-white w-8 h-8 rounded-full flex items-center justify-center border-2 border-white dark:border-slate-700 shadow-sm">
                        <i class="fa-solid fa-user text-xs"></i>
                    </div>
                </div>
                
                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-1 group-hover:text-primary transition-colors pointer-events-none">{{ $aparatur->nama }}</h3>
                <p class="text-primary font-medium mb-2 pointer-events-none">{{ $aparatur->jabatan }}</p>
                @if($aparatur->nip)
                <p class="text-xs text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-700/50 py-1 px-3 rounded-full inline-block mb-4 pointer-events-none">
                    NIP: {{ $aparatur->nip }}
                </p>
                @endif

                <div class="flex justify-center gap-3 relative z-10">
                    @if($aparatur->telepon)
                    <a href="https://wa.me/{{ $aparatur->telepon }}" target="_blank" class="w-8 h-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center hover:bg-green-600 hover:text-white transition-colors">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                    @endif
                    @if($aparatur->email)
                    <a href="mailto:{{ $aparatur->email }}" class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-colors">
                        <i class="fa-regular fa-envelope"></i>
                    </a>
                    @endif
                </div>
                <div class="mt-4 text-primary font-semibold text-sm transition-opacity pointer-events-none">
                    Lihat Profil <i class="fa-solid fa-arrow-right ml-1"></i>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

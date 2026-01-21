@extends('layouts.app')

@section('title', $aparatur->nama . ' - Pemerintahan ' . ($identitasDesa->nama_desa ?? 'Desa Tundagan'))

@section('content')
{{-- Breadcrumb --}}
<section class="pt-24 pb-6 bg-slate-50 dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800">
    <div class="container mx-auto px-4">
    </div>
</section>

{{-- Main Content --}}
<section class="py-16 bg-white dark:bg-dark transition-colors duration-300">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            {{-- Profile Header --}}
            <div class="bg-gradient-to-r from-blue-600 to-cyan-600 rounded-3xl p-8 md:p-12 mb-8 text-white relative overflow-hidden">
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
                <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">
                    <div class="relative">
                        <div class="w-40 h-40 rounded-2xl overflow-hidden shadow-2xl border-4 border-white/30">
                            @if($aparatur->foto)
                            <img data-src="{{ asset('storage/' . $aparatur->foto) }}" 
                                 src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300'%3E%3C/svg%3E"
                                 alt="{{ $aparatur->nama }}"
                                 class="lazy-image w-full h-full object-cover">
                            @else
                            <img data-src="https://ui-avatars.com/api/?name={{ urlencode($aparatur->nama) }}&color=ffffff&background=3b82f6&size=400" 
                                 src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300'%3E%3C/svg%3E"
                                 alt="{{ $aparatur->nama }}"
                                 class="lazy-image w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="absolute -bottom-2 -right-2 bg-white text-primary w-10 h-10 rounded-full flex items-center justify-center shadow-lg">
                            <i class="fa-solid fa-check text-lg"></i>
                        </div>
                    </div>
                    <div class="flex-1 text-center md:text-left">
                        <h1 class="text-3xl md:text-4xl font-bold mb-2">{{ $aparatur->nama }}</h1>
                        <p class="text-xl text-blue-100 mb-4 font-medium">{{ $aparatur->jabatan }}</p>
                        @if($aparatur->nip)
                        <div class="inline-block bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm">
                            NIP: {{ $aparatur->nip }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Information Grid --}}
            <div class="grid md:grid-cols-2 gap-6 mb-8">
                {{-- Contact Information --}}
                <div class="bg-slate-50 dark:bg-slate-800 rounded-2xl p-6">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-address-card text-primary"></i> Informasi Kontak
                    </h3>
                    <div class="space-y-3">
                        @if($aparatur->email)
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center text-primary flex-shrink-0">
                                <i class="fa-regular fa-envelope"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">Email</p>
                                <a href="mailto:{{ $aparatur->email }}" class="text-slate-800 dark:text-white hover:text-primary transition-colors break-all">
                                    {{ $aparatur->email }}
                                </a>
                            </div>
                        </div>
                        @endif

                        @if($aparatur->telepon)
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center text-green-600 flex-shrink-0">
                                <i class="fa-brands fa-whatsapp"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">WhatsApp</p>
                                <a href="https://wa.me/{{ $aparatur->telepon }}" target="_blank" class="text-slate-800 dark:text-white hover:text-green-600 transition-colors">
                                    {{ $aparatur->telepon }}
                                </a>
                            </div>
                        </div>
                        @endif

                        @if($aparatur->alamat)
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center text-orange-600 flex-shrink-0">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">Alamat</p>
                                <p class="text-slate-800 dark:text-white">{{ $aparatur->alamat }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Additional Information --}}
                <div class="bg-slate-50 dark:bg-slate-800 rounded-2xl p-6">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-info-circle text-primary"></i> Informasi Jabatan
                    </h3>
                    <div class="space-y-3">
                        @if($aparatur->pendidikan)
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center text-purple-600 flex-shrink-0">
                                <i class="fa-solid fa-graduation-cap"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">Pendidikan</p>
                                <p class="text-slate-800 dark:text-white">{{ $aparatur->pendidikan }}</p>
                            </div>
                        </div>
                        @endif

                        @if($aparatur->tanggal_mulai_jabatan)
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-cyan-100 dark:bg-cyan-900/30 rounded-lg flex items-center justify-center text-cyan-600 flex-shrink-0">
                                <i class="fa-regular fa-calendar-check"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">Mulai Menjabat</p>
                                <p class="text-slate-800 dark:text-white">{{ $aparatur->tanggal_mulai_jabatan->format('d F Y') }}</p>
                            </div>
                        </div>
                        @endif

                        @if($aparatur->tanggal_selesai_jabatan)
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center text-red-600 flex-shrink-0">
                                <i class="fa-regular fa-calendar-xmark"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">Akhir Masa Jabatan</p>
                                <p class="text-slate-800 dark:text-white">{{ $aparatur->tanggal_selesai_jabatan->format('d F Y') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Biography --}}
            @if($aparatur->bio)
            <div class="bg-slate-50 dark:bg-slate-800 rounded-2xl p-8 mb-8">
                <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-user text-primary"></i> Profil & Biografi
                </h3>
                <div class="prose dark:prose-invert max-w-none text-slate-600 dark:text-slate-300">
                    {!! nl2br(e($aparatur->bio)) !!}
                </div>
            </div>
            @endif

            {{-- Action Buttons --}}
            <div class="flex flex-wrap gap-4 mb-12">
                @if($aparatur->email)
                <a href="mailto:{{ $aparatur->email }}" 
                   class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                    <i class="fa-regular fa-envelope"></i>
                    <span>Kirim Email</span>
                </a>
                @endif

                @if($aparatur->telepon)
                <a href="https://wa.me/{{ $aparatur->telepon }}" 
                   target="_blank"
                   class="inline-flex items-center gap-2 bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                    <i class="fa-brands fa-whatsapp"></i>
                    <span>Hubungi via WhatsApp</span>
                </a>
                @endif
            </div>

            {{-- Related Aparatur --}}
            @if($relatedAparatur->count() > 0)
            <div class="border-t border-slate-200 dark:border-slate-700 pt-12">
                <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-6">Aparatur Desa Lainnya</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    @foreach($relatedAparatur as $related)
                    <a href="{{ route('aparatur.detail', $related->slug) }}" class="group text-center">
                        <div class="relative w-20 h-20 mx-auto mb-3 rounded-full overflow-hidden ring-2 ring-slate-200 dark:ring-slate-700 group-hover:ring-primary transition-all">
                            @if($related->foto)
                            <img data-src="{{ asset('storage/' . $related->foto) }}" 
                                 src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300'%3E%3C/svg%3E"
                                 alt="{{ $related->nama }}"
                                 class="lazy-image w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            @else
                            <img data-src="https://ui-avatars.com/api/?name={{ urlencode($related->nama) }}&color=7F9CF5&background=EBF4FF" 
                                 src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300'%3E%3C/svg%3E"
                                 alt="{{ $related->nama }}"
                                 class="lazy-image w-full h-full object-cover">
                            @endif
                        </div>
                        <p class="text-sm font-semibold text-slate-800 dark:text-white group-hover:text-primary transition-colors line-clamp-2">
                            {{ $related->nama }}
                        </p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-1">{{ $related->jabatan }}</p>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Back Button --}}
            <div class="mt-12 text-center">
                <a href="{{ route('pemerintahan') }}" 
                   class="inline-flex items-center gap-2 text-primary font-semibold hover:underline">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Kembali ke Pemerintahan Desa</span>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@extends('layouts.app')

@section('title', 'Profil Desa - ' . ($identitasDesa->nama_desa ?? 'Desa Tundagan'))

@push('styles')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 bg-slate-50 dark:bg-slate-900 overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#3b82f6_1px,transparent_1px)] [background-size:16px_16px]"></div>
    
        <div class="container mx-auto px-4 relative z-10 text-center">
            <span class="text-primary font-semibold tracking-wider uppercase text-sm animate-fade-in-up">Mengenal Desa</span>
            <h1 class="text-4xl md:text-6xl font-bold text-slate-800 dark:text-white mt-2 mb-6 animate-fade-in-up">
                Profil {{ $identitasDesa->nama_desa ?? 'Desa Tundagan' }}
            </h1>
            <p class="text-lg md:text-xl text-slate-600 dark:text-slate-400 max-w-2xl mx-auto animate-fade-in-up [animation-delay:200ms]">
                Mengenal lebih dekat {{ $identitasDesa->nama_desa ?? 'Desa Tundagan' }} dengan segala potensi dan keistimewaannya
            </p>
        </div>
    </section>

{{-- Tabs Navigation --}}
<div class="sticky top-0 z-40 bg-white dark:bg-dark border-b border-slate-200 dark:border-slate-700 shadow-sm">
    <div class="container mx-auto px-4">
        <div class="flex overflow-x-auto scrollbar-hide gap-1 py-2">
            {{-- Sambutan Tab (Always First) --}}
            <button onclick="switchTab('sambutan')" data-tab="sambutan" class="tab-button active flex-shrink-0 px-6 py-3 text-sm font-medium rounded-lg transition-colors bg-primary/10 text-primary">
                <i class="fa-solid fa-user-tie mr-2"></i> Sambutan
            </button>
            
            {{-- dynamic tabs --}}
            @foreach($profilDesa as $profil)
                @if($profil->slug !== 'sambutan')
                <button onclick="switchTab('{{ $profil->slug }}')" data-tab="{{ $profil->slug }}" class="tab-button flex-shrink-0 px-6 py-3 text-sm font-medium rounded-lg transition-colors hover:bg-primary/10 hover:text-primary">
                    <i class="{{ $profil->icon ?? 'fa-solid fa-file' }} mr-2"></i> {{ $profil->judul }}
                </button>
                @endif
            @endforeach

            {{-- New Unified Tabs --}}
            <button onclick="switchTab('pemerintahan')" data-tab="pemerintahan" class="tab-button flex-shrink-0 px-6 py-3 text-sm font-medium rounded-lg transition-colors hover:bg-primary/10 hover:text-primary">
                <i class="fa-solid fa-sitemap mr-2"></i> Pemerintahan
            </button>
            <button onclick="switchTab('statistik')" data-tab="statistik" class="tab-button flex-shrink-0 px-6 py-3 text-sm font-medium rounded-lg transition-colors hover:bg-primary/10 hover:text-primary">
                <i class="fa-solid fa-chart-pie mr-2"></i> Statistik
            </button>
        </div>
    </div>
</div>

{{-- Content Sections --}}
<div class="bg-slate-50 dark:bg-slate-900 py-16">
    <div class="container mx-auto px-4 max-w-6xl">
        
        {{-- Sambutan Kepala Desa --}}
        <section id="sambutan" data-tab-content="sambutan" class="tab-content">
            <div class="bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-slate-800 dark:to-slate-700 rounded-3xl p-8 md:p-12 border-2 border-blue-100 dark:border-blue-900 shadow-xl">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-16 h-16 bg-primary rounded-2xl flex items-center justify-center text-white text-2xl">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-slate-800 dark:text-white">Sambutan Kepala Desa</h2>
                        <p class="text-slate-600 dark:text-slate-400">Kata pengantar dari pimpinan desa</p>
                    </div>
                </div>

                @if($kepalaDesa)
                <div class="grid md:grid-cols-3 gap-8 items-start">
                    <div class="text-center">
                        <div class="relative w-48 h-48 mx-auto mb-6">
                            <div class="absolute inset-0 bg-primary/20 rounded-3xl transform rotate-6"></div>
                            @if($kepalaDesa->foto)
                            <img data-src="{{ asset('storage/' . $kepalaDesa->foto) }}" 
                                src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300'%3E%3C/svg%3E"
                                alt="{{ $kepalaDesa->nama }}"
                                class="lazy-image relative w-full h-full object-cover rounded-3xl border-4 border-white dark:border-slate-600 shadow-2xl">
                            @else
                            <img data-src="https://ui-avatars.com/api/?name={{ urlencode($kepalaDesa->nama) }}&color=ffffff&background=3b82f6&size=400" 
                                src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300'%3E%3C/svg%3E"
                                alt="{{ $kepalaDesa->nama }}"
                                class="lazy-image relative w-full h-full object-cover rounded-3xl border-4 border-white dark:border-slate-600 shadow-2xl">
                            @endif
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-1">{{ $kepalaDesa->nama }}</h3>
                        <p class="text-primary font-semibold mb-2">{{ $kepalaDesa->jabatan }}</p>
                        @if($kepalaDesa->tanggal_mulai_jabatan)
                        <p class="text-sm text-slate-600 dark:text-slate-400">
                            Masa Jabatan: {{ $kepalaDesa->tanggal_mulai_jabatan->format('Y') }} - 
                            {{ $kepalaDesa->tanggal_selesai_jabatan ? $kepalaDesa->tanggal_selesai_jabatan->format('Y') : 'Sekarang' }}
                        </p>
                        @endif
                    </div>

                    <div class="md:col-span-2">
                        @php
                            $sambutan = $profilDesa->where('slug', 'sambutan')->first();
                        @endphp
                        
                        <div class="prose dark:prose-invert max-w-none">
                            @if($sambutan && $sambutan->konten)
                                {{-- Use content from admin panel --}}
                                <div class="text-slate-700 dark:text-slate-300 leading-relaxed">
                                    {!! $sambutan->konten !!}
                                    
                                    <div class="mt-6 text-right">
                                        <p class="font-semibold text-slate-800 dark:text-white">{{ $kepalaDesa->nama }}</p>
                                        <p class="text-sm text-slate-600 dark:text-slate-400">Kepala Desa</p>
                                    </div>
                                </div>
                            @elseif($kepalaDesa->bio)
                                {{-- Fallback to Kepala Desa bio --}}
                                <div class="text-slate-700 dark:text-slate-300 leading-relaxed">
                                    {!! nl2br(e($kepalaDesa->bio)) !!}
                                    
                                    <div class="mt-6 text-right">
                                        <p class="font-semibold text-slate-800 dark:text-white">{{ $kepalaDesa->nama }}</p>
                                        <p class="text-sm text-slate-600 dark:text-slate-400">Kepala Desa</p>
                                    </div>
                                </div>
                            @else
                                {{-- Default fallback message --}}
                                <p class="text-slate-700 dark:text-slate-300 leading-relaxed italic">
                                    Belum ada Sambutan 
                                </p>
                                <div class="mt-6 text-right">
                                    <p class="font-semibold text-slate-800 dark:text-white">{{ $kepalaDesa->nama }}</p>
                                    <p class="text-sm text-slate-600 dark:text-slate-400">Kepala Desa</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @else
                <div class="text-center py-8">
                    <i class="fa-solid fa-user-tie text-slate-300 text-6xl mb-4"></i>
                    <p class="text-slate-500">Data Kepala Desa belum tersedia</p>
                </div>
                @endif
            </div>
        </section>



        {{-- Dynamic Sections from ProfilDesa --}}
        @php
            $colorClasses = [
                'bg-amber-100 dark:bg-amber-900/30 text-amber-600',
                'bg-blue-100 dark:bg-blue-900/30 text-blue-600',
                'bg-green-100 dark:bg-green-900/30 text-green-600',
                'bg-purple-100 dark:bg-purple-900/30 text-purple-600',
                'bg-cyan-100 dark:bg-cyan-900/30 text-cyan-600',
                'bg-red-100 dark:bg-red-900/30 text-red-600',
                'bg-orange-100 dark:bg-orange-900/30 text-orange-600',
                'bg-pink-100 dark:bg-pink-900/30 text-pink-600',
            ];
        @endphp

        @foreach($profilDesa as $index => $profil)
            @if($profil->slug ===  'geografis')
                {{-- Special Geografis Layout with Map --}}
                <section id="geografis" data-tab-content="geografis" class="tab-content hidden">
                    <div class="bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-sm">
                        {{-- Header --}}
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center text-green-600 text-xl">
                                <i class="{{ $profil->icon ?? 'fa-solid fa-map-location-dot' }}"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-slate-800 dark:text-white">{{ $profil->judul }}</h2>
                                <p class="text-slate-600 dark:text-slate-400 text-sm">Letak, batas wilayah, dan peta lokasi</p>
                            </div>
                        </div>
                        
                        {{-- Map & Border Info Grid --}}
                        <div class="grid lg:grid-cols-3 gap-6 mb-6">
                            {{-- OpenStreetMap with Leaflet --}}
                            <div class="lg:col-span-2">
                                @if($identitasDesa && $identitasDesa->latitude && $identitasDesa->longitude)
                                    <div id="geografis-map" class="bg-slate-50 dark:bg-slate-700 rounded-xl overflow-hidden h-96"></div>
                                @else
                                    <div class="bg-slate-50 dark:bg-slate-700 rounded-xl h-96 flex items-center justify-center text-slate-400">
                                        <div class="text-center">
                                            <i class="fa-solid fa-map-location-dot text-6xl mb-4"></i>
                                            <p class="font-semibold">Koordinat belum diatur</p>
                                            <p class="text-sm mt-2">Silakan atur di panel Admin → Identitas Desa</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            {{-- Compass & Border Info --}}
                            <div class="space-y-4">
                                {{-- Compass --}}
                                <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-slate-700 dark:to-slate-600 rounded-xl p-6 text-center">
                                    <div class="relative w-32 h-32 mx-auto mb-4">
                                        <div class="absolute inset-0 border-4 border-green-500 rounded-full"></div>
                                        <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-2 w-8 h-8 bg-red-500 rounded-full flex items-center justify-center text-white font-bold text-xs">U</div>
                                        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-2 w-8 h-8 bg-slate-400 rounded-full flex items-center justify-center text-white font-bold text-xs">S</div>
                                        <div class="absolute right-0 top-1/2 translate-x-2 -translate-y-1/2 w-8 h-8 bg-slate-400 rounded-full flex items-center justify-center text-white font-bold text-xs">T</div>
                                        <div class="absolute left-0 top-1/2 -translate-x-2 -translate-y-1/2 w-8 h-8 bg-slate-400 rounded-full flex items-center justify-center text-white font-bold text-xs">B</div>
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <i class="fa-solid fa-house text-green-600 text-2xl"></i>
                                        </div>
                                    </div>
                                    <p class="text-sm text-slate-600 dark:text-slate-300 font-medium">{{ $identitasDesa->nama_desa ?? 'Desa' }}</p>
                                </div>
                                
                                {{-- Border Info Table --}}
                                <div class="bg-white dark:bg-slate-700 rounded-xl border border-slate-200 dark:border-slate-600 overflow-hidden">
                                    <div class="bg-green-500 text-white px-4 py-2 font-semibold text-sm">
                                        Batas Wilayah
                                    </div>
                                    <table class="w-full text-sm">
                                        <tbody>
                                            <tr class="border-b border-slate-200 dark:border-slate-600">
                                                <td class="px-4 py-3 text-slate-600 dark:text-slate-400">
                                                    <i class="fa-solid fa-arrow-up text-red-500 text-xs mr-2"></i>Utara
                                                </td>
                                                <td class="px-4 py-3 text-slate-800 dark:text-white font-medium text-right">
                                                    {{ $identitasDesa->batas_utara ?? '-' }}
                                                </td>
                                            </tr>
                                            <tr class="border-b border-slate-200 dark:border-slate-600">
                                                <td class="px-4 py-3 text-slate-600 dark:text-slate-400">
                                                    <i class="fa-solid fa-arrow-right text-slate-500 text-xs mr-2"></i>Timur
                                                </td>
                                                <td class="px-4 py-3 text-slate-800 dark:text-white font-medium text-right">
                                                    {{ $identitasDesa->batas_timur ?? '-' }}
                                                </td>
                                            </tr>
                                            <tr class="border-b border-slate-200 dark:border-slate-600">
                                                <td class="px-4 py-3 text-slate-600 dark:text-slate-400">
                                                    <i class="fa-solid fa-arrow-down text-slate-500 text-xs mr-2"></i>Selatan
                                                </td>
                                                <td class="px-4 py-3 text-slate-800 dark:text-white font-medium text-right">
                                                    {{ $identitasDesa->batas_selatan ?? '-' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="px-4 py-3 text-slate-600 dark:text-slate-400">
                                                    <i class="fa-solid fa-arrow-left text-slate-500 text-xs mr-2"></i>Barat
                                                </td>
                                                <td class="px-4 py-3 text-slate-800 dark:text-white font-medium text-right">
                                                    {{ $identitasDesa->batas_barat ?? '-' }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Rich Text Content from Admin --}}
                        @if($profil->konten)
                        <div class="prose dark:prose-invert max-w-none mt-6 pt-6 border-t border-slate-200 dark:border-slate-700">
                            {!! $profil->konten !!}
                        </div>
                        @endif
                    </div>
                </section>
            @else
                {{-- Regular Section Layout --}}
                <section id="{{ $profil->slug }}" data-tab-content="{{ $profil->slug }}" class="tab-content hidden">
                    <div class="bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-sm">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 {{ $colorClasses[$index % count($colorClasses)] }} rounded-xl flex items-center justify-center text-xl">
                                <i class="{{ $profil->icon ?? 'fa-solid fa-file' }}"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-slate-800 dark:text-white">{{ $profil->judul }}</h2>
                                <p class="text-slate-600 dark:text-slate-400 text-sm">{{ $profil->slug }}</p>
                            </div>
                        </div>
                        
                        <div class="prose dark:prose-invert max-w-none">
                            {!! $profil->konten !!}
                        </div>
                    </div>
                </section>
            @endif
        @endforeach

        {{-- Section Pemerintahan (Ported) --}}
        <section id="pemerintahan" data-tab-content="pemerintahan" class="tab-content hidden">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-8 shadow-sm border border-slate-100 dark:border-slate-700">
                <div class="flex items-center gap-4 mb-10">
                    <div class="w-14 h-14 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center text-blue-600 text-xl">
                        <i class="fa-solid fa-sitemap"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Struktur Organisasi</h2>
                        <p class="text-slate-600 dark:text-slate-400 text-sm">Jajaran aparatur pemerintah desa</p>
                    </div>
                </div>

                <div class="space-y-12">
                    @php
                        $kades_p = $aparaturDesa->where('jabatan', 'Kepala Desa')->first();
                        
                        // Select 6 random officials (excluding Kepala Desa) to keep it dynamic and fresh
                        $others_p = $aparaturDesa->where('jabatan', '!=', 'Kepala Desa')->shuffle()->take(6);
                    @endphp

                    @if($kades_p)
                    <div class="flex justify-center">
                        <div class="w-full max-w-sm">
                            <div class="bg-slate-50 dark:bg-slate-700/30 rounded-2xl p-6 text-center border border-primary/20">
                                <img src="{{ $kades_p->foto ? asset('storage/' . $kades_p->foto) : 'https://ui-avatars.com/api/?name='.urlencode($kades_p->nama) }}" class="w-32 h-32 mx-auto rounded-full object-cover border-4 border-white dark:border-slate-600 shadow-lg mb-4">
                                <h3 class="font-bold text-lg dark:text-white">{{ $kades_p->nama }}</h3>
                                <p class="text-primary font-semibold text-sm">{{ $kades_p->jabatan }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($others_p as $ap)
                        <div class="bg-white dark:bg-slate-700 p-4 rounded-xl border border-slate-100 dark:border-slate-600 text-center">
                             <img src="{{ $ap->foto ? asset('storage/' . $ap->foto) : 'https://ui-avatars.com/api/?name='.urlencode($ap->nama) }}" class="w-20 h-20 mx-auto rounded-full object-cover border-2 border-white dark:border-slate-500 shadow-md mb-3">
                             <h4 class="font-bold text-sm dark:text-white">{{ $ap->nama }}</h4>
                             <p class="text-primary text-xs">{{ $ap->jabatan }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-12 pt-8 border-t border-slate-100 dark:border-slate-700 text-center">
                    <a href="{{ route('pemerintahan') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-primary text-white font-bold rounded-xl hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
                        Lihat Struktur Organisasi Selengkapnya <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </section>

        {{-- Section Statistik (Ported) --}}
        <section id="statistik" data-tab-content="statistik" class="tab-content hidden">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-8 shadow-sm border border-slate-100 dark:border-slate-700">
                <div class="flex items-center gap-4 mb-10">
                    <div class="w-14 h-14 bg-amber-100 dark:bg-amber-900/30 rounded-xl flex items-center justify-center text-amber-600 text-xl">
                        <i class="fa-solid fa-chart-pie"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Statistik Penduduk</h2>
                        <p class="text-slate-600 dark:text-slate-400 text-sm">Data demografi desa berdasarkan kependudukan</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-slate-50 dark:bg-slate-700/20 p-6 rounded-2xl">
                        <h4 class="font-bold mb-4 dark:text-white flex items-center gap-2"><i class="fa-solid fa-venus-mars text-primary"></i> Jenis Kelamin</h4>
                        <div class="h-64"><canvas id="genderChart"></canvas></div>
                    </div>
                    <div class="bg-slate-50 dark:bg-slate-700/20 p-6 rounded-2xl">
                        <h4 class="font-bold mb-4 dark:text-white flex items-center gap-2"><i class="fa-solid fa-graduation-cap text-primary"></i> Pendidikan</h4>
                        <div class="h-64"><canvas id="pendidikanChart"></canvas></div>
                    </div>
                    <div class="bg-slate-50 dark:bg-slate-700/20 p-6 rounded-2xl col-span-full">
                        <h4 class="font-bold mb-4 dark:text-white flex items-center gap-2"><i class="fa-solid fa-user-clock text-primary"></i> Kelompok Usia</h4>
                        <div class="h-64"><canvas id="usiaChart"></canvas></div>
                    </div>
                </div>

                <div class="mt-12 pt-8 border-t border-slate-100 dark:border-slate-700 text-center">
                    <a href="{{ route('statistik') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-amber-500 text-white font-bold rounded-xl hover:bg-amber-600 transition-all shadow-lg shadow-amber-500/20">
                        Lihat Data Statistik Lengkap <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </section>


    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function switchTab(tabId) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active state from all tabs
    document.querySelectorAll('.tab-button').forEach(btn => {
        btn.classList.remove('bg-primary/10', 'text-primary');
    });
    
    // Show selected tab content
    const selectedContent = document.querySelector(`[data-tab-content="${tabId}"]`);
    if (selectedContent) {
        selectedContent.classList.remove('hidden');
        
        // Initialize map if showing geografis tab
        if (tabId === 'geografis' && !window.geografisMapInitialized) {
            setTimeout(() => initGeografisMap(), 100);
        }

        // Initialize charts if showing statistik tab
        if (tabId === 'statistik') {
            setTimeout(() => initCharts(), 100);
        }
    }
    
    // Add active state to clicked tab
    const selectedButton = document.querySelector(`[data-tab="${tabId}"]`);
    if (selectedButton) {
        selectedButton.classList.add('bg-primary/10', 'text-primary');
    }
}

// Chart.js logic
function initCharts() {
    const isDark = document.documentElement.classList.contains('dark');
    const textColor = isDark ? '#cbd5e1' : '#475569';
    
    // Gender Chart
    const genderCtx = document.getElementById('genderChart');
    if (genderCtx && !genderCtx.chart) {
        genderCtx.chart = new Chart(genderCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($pendudukByGender->pluck('jenis_kelamin')) !!},
                datasets: [{
                    data: {!! json_encode($pendudukByGender->pluck('total')) !!},
                    backgroundColor: ['#3b82f6', '#ec4899'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom', labels: { color: textColor } } }
            }
        });
    }

    // Pendidikan Chart
    const eduCtx = document.getElementById('pendidikanChart');
    if (eduCtx && !eduCtx.chart) {
        eduCtx.chart = new Chart(eduCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($pendudukByPendidikan->pluck('pendidikan_terakhir')) !!},
                datasets: [{
                    label: 'Jumlah',
                    data: {!! json_encode($pendudukByPendidikan->pluck('total')) !!},
                    backgroundColor: '#10b981'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { color: textColor } }, x: { ticks: { color: textColor } } }
            }
        });
    }

    // Usia Chart
    const ageCtx = document.getElementById('usiaChart');
    if (ageCtx && !ageCtx.chart) {
        ageCtx.chart = new Chart(ageCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($pendudukByUsia->keys()) !!},
                datasets: [{
                    label: 'Jumlah',
                    data: {!! json_encode($pendudukByUsia->values()) !!},
                    backgroundColor: '#f59e0b'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { color: textColor } }, x: { ticks: { color: textColor } } }
            }
        });
    }
}

// Initialize Geografis Map
function initGeografisMap() {
    const mapElement = document.getElementById('geografis-map');
    if (!mapElement || window.geografisMapInitialized) return;
    
    @if($identitasDesa && $identitasDesa->latitude && $identitasDesa->longitude)
    try {
        const map = L.map('geografis-map').setView([{{ $identitasDesa->latitude }}, {{ $identitasDesa->longitude }}], 14);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19, attribution: '© OpenStreetMap'
        }).addTo(map);
        L.marker([{{ $identitasDesa->latitude }}, {{ $identitasDesa->longitude }}]).addTo(map)
            .bindPopup('<b>{{ $identitasDesa->nama_desa }}</b>').openPopup();
        window.geografisMapInitialized = true;
        setTimeout(() => map.invalidateSize(), 100);
    } catch (error) { console.error('Map error:', error); }
    @endif
}

document.addEventListener('DOMContentLoaded', () => {
    // Handle tab from URL parameter or hash
    const urlParams = new URLSearchParams(window.location.search);
    const tabParam = urlParams.get('tab');
    const hashParam = window.location.hash.substring(1);
    
    if (tabParam) switchTab(tabParam);
    else if (hashParam) switchTab(hashParam);
});
</script>
@endpush
@endsection

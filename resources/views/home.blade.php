@extends('layouts.app')

@section('title', 'Beranda - ' . ($identitasDesa->nama_desa ?? 'Desa Tundagan'))

@section('content')
    <!-- Hero Section -->
    <section id="beranda" class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
            <img data-src="{{ $identitasDesa->hero_image_beranda ? asset('storage/' . $identitasDesa->hero_image_beranda) : 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80' }}"
                src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300'%3E%3C/svg%3E"
                alt="Desa Background" class="lazy-image w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-b from-slate-900/70 via-slate-900/50 to-slate-50 dark:to-dark">
            </div>
        </div>

        <div class="container mx-auto px-4 relative z-10 text-center pt-28">
            <div
                class="inline-block mb-4 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white text-sm font-medium animate-fade-in-up">
                <i class="fa-solid fa-check-circle text-green-400 mr-2"></i> Website Resmi Pemerintah Desa
            </div>

            <h1
                class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-white mb-6 leading-tight tracking-tight animate-fade-in-up [animation-delay:200ms]">
                Selamat Datang di <br>
                <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300">{{ $identitasDesa->nama_desa ?? 'Desa Tundagan' }}</span>
            </h1>

            <p
                class="text-lg md:text-xl text-slate-200 mb-10 max-w-2xl mx-auto font-light animate-fade-in-up [animation-delay:400ms]">
                Mewujudkan desa yang mandiri, sejahtera, dan berbudaya melalui pelayanan publik yang prima dan inovasi
                digital.
            </p>

            <div
                class="flex flex-col sm:flex-row gap-4 justify-center items-center animate-fade-in-up [animation-delay:600ms]">
                <a href="#profil"
                    class="px-8 py-4 bg-primary hover:bg-blue-600 text-white rounded-full font-semibold shadow-lg shadow-blue-500/30 transition-all hover:scale-105 flex items-center gap-2">
                    <span>Jelajahi Desa</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
                <a href="{{ route('layanan') }}" wire:navigate
                    class="px-8 py-4 bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/30 text-white rounded-full font-semibold transition-all hover:scale-105 flex items-center gap-2">
                    <i class="fa-solid fa-clipboard-list"></i>
                    <span>Layanan Publik</span>
                </a>
            </div>
        </div>

        <!-- Scroll Down Indicator -->
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce text-white/70">
            <i class="fa-solid fa-chevron-down text-2xl"></i>
        </div>
    </section>
    <!-- Quick Menu Section (Icon Grid) - Mobile Only -->
    <section class="lg:hidden relative z-20 mt-6 pb-6">
        <div class="container mx-auto px-4 text-center">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-100 dark:border-slate-700 px-2 py-5">
                <div class="grid grid-cols-4 gap-y-5 gap-x-1">
                    @php
                        $quickMenus = [
                            ['route' => 'profil', 'label' => 'Profil Desa', 'icon' => 'fa-id-card-clip', 'color' => 'blue'],
                            ['route' => 'layanan', 'label' => 'Layanan', 'icon' => 'fa-file-invoice', 'color' => 'emerald'],
                            ['route' => 'blog', 'label' => 'Kabar Desa', 'icon' => 'fa-newspaper', 'color' => 'purple'],
                            ['route' => 'galeri', 'label' => 'Galeri', 'icon' => 'fa-images', 'color' => 'pink'],
                            ['route' => 'umkm', 'label' => 'Potensi', 'icon' => 'fa-shop', 'color' => 'amber'],
                            ['route' => 'anggaran-desa', 'label' => 'Transparansi', 'icon' => 'fa-chart-pie', 'color' => 'red'],
                            ['route' => 'informasi-publik', 'label' => 'Info Publik', 'icon' => 'fa-circle-info', 'color' => 'cyan'],
                            ['route' => 'statistik', 'label' => 'Statistik', 'icon' => 'fa-chart-column', 'color' => 'indigo'],
                        ];
                    @endphp

                    @foreach($quickMenus as $item)
                        <a href="{{ route($item['route']) }}" wire:navigate class="group flex flex-col items-center gap-2">
                            <div class="w-12 h-12 rounded-xl bg-{{ $item['color'] }}-100 dark:bg-{{ $item['color'] }}-900/30 text-{{ $item['color'] }}-600 dark:text-{{ $item['color'] }}-400 flex items-center justify-center text-lg shadow-sm group-hover:scale-105 transition-all duration-300">
                                <i class="fa-solid {{ $item['icon'] }}"></i>
                            </div>
                            <span class="text-[8px] font-bold text-slate-700 dark:text-slate-300 leading-tight">
                                {{ $item['label'] }}
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Profil Desa Section -->
    <section id="profil" class="py-20 bg-white dark:bg-dark transition-colors duration-300">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <span class="text-primary font-semibold tracking-wider uppercase text-sm">Tentang Kami</span>
                <h2 class="text-3xl md:text-4xl font-bold text-slate-800 dark:text-white mt-2 mb-4">Profil
                    {{ $identitasDesa->nama_desa ?? 'Desa Tundagan' }}</h2>
                <div class="w-20 h-1.5 bg-primary mx-auto rounded-full"></div>
                <p class="text-slate-600 dark:text-slate-400 mt-4 max-w-2xl mx-auto">
                    Mengenal lebih dekat sejarah, visi, misi, dan potensi yang dimiliki oleh
                    {{ $identitasDesa->nama_desa ?? 'Desa Tundagan' }}.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-8">
                @forelse($profilDesa as $profil)
                    <!-- Card Item -->
                    <div
                        class="group p-5 md:p-8 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-700 hover:shadow-xl hover:shadow-primary/5 transition-all duration-300 hover:-translate-y-2 flex flex-col items-center md:items-start text-center md:text-left h-full">

                        <!-- Clickable area (opens modal on mobile, or when clicking icon/title on desktop) -->
                        <div onclick="openProfilModal('{{ $profil->judul }}', '{{ $profil->icon ?? 'fa-solid fa-circle-info' }}', `{{ $profil->konten }}`)"
                            class="cursor-pointer flex flex-col items-center md:items-start text-center md:text-left w-full">
                            <div
                                class="w-12 h-12 md:w-14 md:h-14 bg-blue-100 dark:bg-blue-900/30 text-primary rounded-xl flex items-center justify-center text-xl md:text-2xl mb-4 md:mb-6 group-hover:scale-110 transition-transform duration-300">
                                <i class="{{ $profil->icon ?? 'fa-solid fa-circle-info' }}"></i>
                            </div>

                            <h3 class="text-sm md:text-xl font-bold text-slate-800 dark:text-white mb-2 md:mb-3 line-clamp-2">
                                {{ $profil->judul }}</h3>
                        </div>

                        <!-- Content visible only on desktop, hidden on mobile (NOT clickable for modal) -->
                        <div
                            class="hidden md:block text-slate-600 dark:text-slate-400 leading-relaxed text-sm md:text-base mb-4 flex-grow">
                            @php
                                $plainText = strip_tags($profil->konten);
                                $truncated = Str::limit($plainText, 200, '...');
                            @endphp
                            <p>{{ $truncated }}</p>
                        </div>

                        <!-- Mobile indicator (clickable to open modal) -->
                        <div onclick="openProfilModal('{{ $profil->judul }}', '{{ $profil->icon ?? 'fa-solid fa-circle-info' }}', `{{ $profil->konten }}`)"
                            class="md:hidden mt-auto pt-2 text-xs text-primary font-medium flex items-center gap-1 opacity-80 cursor-pointer">
                            <span>Lihat Detail</span>
                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <i class="fa-solid fa-circle-info text-gray-300 text-6xl mb-4"></i>
                        <p class="text-gray-500 text-lg">Belum ada data profil desa</p>
                    </div>
                @endforelse
            </div>

            <!-- Single Button to Profile Page (Desktop Only) -->
            <div class="hidden md:flex justify-center mt-12">
                <a href="{{ route('profil') }}" wire:navigate
                    class="px-8 py-4 bg-primary hover:bg-blue-600 text-white rounded-full font-semibold shadow-lg shadow-primary/30 transition-all hover:scale-105 flex items-center gap-2">
                    <span>Lihat Semua Profil Desa</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

        </div>



        <!-- Profil Detail Modal -->
        <div id="profil-modal-backdrop" onclick="if(event.target === this) closeProfilModal()"
            class="fixed inset-0 z-[9999] bg-black/60 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300 flex items-center justify-center p-4">
            <div id="profil-modal-content"
                class="bg-white dark:bg-slate-900 w-full max-w-2xl rounded-3xl shadow-2xl transform scale-95 opacity-0 transition-all duration-300 max-h-[85vh] flex flex-col">

                <!-- Modal Header -->
                <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between shrink-0">
                    <div class="flex items-center gap-4">
                        <div id="modal-icon-container"
                            class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 text-primary rounded-lg flex items-center justify-center text-lg">
                            <i id="modal-icon" class=""></i>
                        </div>
                        <h3 id="modal-title" class="text-xl font-bold text-slate-800 dark:text-white"></h3>
                    </div>
                    <button onclick="closeProfilModal()"
                        class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:bg-red-100 hover:text-red-500 transition-colors">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6 overflow-y-auto custom-scrollbar">
                    <div id="modal-body" class="prose dark:prose-invert max-w-none text-slate-600 dark:text-slate-300">
                        <!-- Content will be injected here -->
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="p-4 border-t border-slate-100 dark:border-slate-800 shrink-0 flex justify-end">
                    <button onclick="closeProfilModal()"
                        class="px-6 py-2 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-full font-medium hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                        Tutup
                    </button>
                </div>
            </div>
        </div>

        <script>
            // Profil Modal Logic - Robust for Livewire
            (function () {
                window.openProfilModal = function (title, iconClass, content) {
                    const modalBackdrop = document.getElementById('profil-modal-backdrop');
                    const modalContent = document.getElementById('profil-modal-content');
                    const modalTitle = document.getElementById('modal-title');
                    const modalIcon = document.getElementById('modal-icon');
                    const modalBody = document.getElementById('modal-body');

                    if (!modalBackdrop || !modalContent) return;

                    // Set content
                    if (modalTitle) modalTitle.textContent = title;
                    if (modalIcon) modalIcon.className = iconClass;
                    if (modalBody) modalBody.innerHTML = content;

                    // Show modal
                    modalBackdrop.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');

                    // Animate in
                    requestAnimationFrame(() => {
                        modalBackdrop.classList.remove('opacity-0');
                        modalContent.classList.remove('scale-95', 'opacity-0');
                        modalContent.classList.add('scale-100', 'opacity-100');
                    });
                }

                window.closeProfilModal = function () {
                    const modalBackdrop = document.getElementById('profil-modal-backdrop');
                    const modalContent = document.getElementById('profil-modal-content');

                    if (!modalBackdrop || !modalContent) return;

                    // Animate out
                    modalBackdrop.classList.add('opacity-0');
                    modalContent.classList.remove('scale-100', 'opacity-100');
                    modalContent.classList.add('scale-95', 'opacity-0');

                    // Hide after animation
                    setTimeout(() => {
                        modalBackdrop.classList.add('hidden');
                        document.body.classList.remove('overflow-hidden');
                    }, 300);
                }

                // Handle Escape key
                if (window.profilEscapeHandler) {
                    document.removeEventListener('keydown', window.profilEscapeHandler);
                }
                window.profilEscapeHandler = (e) => {
                    const modalBackdrop = document.getElementById('profil-modal-backdrop');
                    if (e.key === 'Escape' && modalBackdrop && !modalBackdrop.classList.contains('hidden')) {
                        window.closeProfilModal();
                    }
                };
                document.addEventListener('keydown', window.profilEscapeHandler);
            })();
        </script>
    </section>

    <!-- Statistik Desa Section -->
    <section id="statistik" class="py-20 bg-blue-600 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center mb-16">
                <span class="text-blue-200 font-semibold tracking-wider uppercase text-sm">Data Demografi</span>
                <h2 class="text-3xl md:text-4xl font-bold mt-2 mb-4">Statistik Desa</h2>
                <div class="w-20 h-1.5 bg-white mx-auto rounded-full"></div>
                <p class="text-blue-100 mt-4 max-w-2xl mx-auto">
                    Gambaran umum kondisi demografi penduduk {{ $identitasDesa->nama_desa ?? 'Desa Tundagan' }}.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-8 mb-12">
                <!-- Total Penduduk -->
                <div
                    class="bg-white/10 backdrop-blur-md rounded-xl md:rounded-2xl p-4 md:p-6 border border-white/20 text-center hover:transform hover:scale-105 transition-all duration-300">
                    <div
                        class="w-10 h-10 md:w-16 md:h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-2 md:mb-4 text-xl md:text-3xl">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <h3 class="text-2xl md:text-4xl font-bold mb-1 md:mb-2 counter" data-target="{{ $totalPenduduk ?? 0 }}">
                        0</h3>
                    <p class="text-blue-100 text-xs md:text-base">Total Penduduk</p>
                </div>

                <!-- Laki-laki -->
                <div
                    class="bg-white/10 backdrop-blur-md rounded-xl md:rounded-2xl p-4 md:p-6 border border-white/20 text-center hover:transform hover:scale-105 transition-all duration-300">
                    <div
                        class="w-10 h-10 md:w-16 md:h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-2 md:mb-4 text-xl md:text-3xl">
                        <i class="fa-solid fa-person"></i>
                    </div>
                    <h3 class="text-2xl md:text-4xl font-bold mb-1 md:mb-2 counter" data-target="{{ $totalLakiLaki ?? 0 }}">
                        0</h3>
                    <p class="text-blue-100 text-xs md:text-base">Laki-laki</p>
                </div>

                <!-- Perempuan -->
                <div
                    class="bg-white/10 backdrop-blur-md rounded-xl md:rounded-2xl p-4 md:p-6 border border-white/20 text-center hover:transform hover:scale-105 transition-all duration-300">
                    <div
                        class="w-10 h-10 md:w-16 md:h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-2 md:mb-4 text-xl md:text-3xl">
                        <i class="fa-solid fa-person-dress"></i>
                    </div>
                    <h3 class="text-2xl md:text-4xl font-bold mb-1 md:mb-2 counter"
                        data-target="{{ $totalPerempuan ?? 0 }}">0</h3>
                    <p class="text-blue-100 text-xs md:text-base">Perempuan</p>
                </div>

                <!-- Kepala Keluarga -->
                <div
                    class="bg-white/10 backdrop-blur-md rounded-xl md:rounded-2xl p-4 md:p-6 border border-white/20 text-center hover:transform hover:scale-105 transition-all duration-300">
                    <div
                        class="w-10 h-10 md:w-16 md:h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-2 md:mb-4 text-xl md:text-3xl">
                        <i class="fa-solid fa-house-user"></i>
                    </div>
                    <h3 class="text-2xl md:text-4xl font-bold mb-1 md:mb-2 counter"
                        data-target="{{ $totalKepalaKeluarga ?? 0 }}">0</h3>
                    <p class="text-blue-100 text-xs md:text-base">Kepala Keluarga</p>
                </div>
            </div>

            <div class="text-center">
                <a href="{{ route('statistik') }}" wire:navigate
                    class="inline-flex items-center gap-2 bg-white text-blue-600 px-8 py-3 rounded-full font-bold hover:bg-blue-50 transition-colors shadow-lg">
                    <span>Lihat Statistik Lengkap</span>
                    <i class="fa-solid fa-chart-pie"></i>
                </a>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            (function () {
                const initStatsAnimation = () => {
                    const counters = document.querySelectorAll('.counter');
                    const duration = 1000; // Animation duration in ms (1 second)

                    const animateCounters = () => {
                        counters.forEach(counter => {
                            const target = +counter.getAttribute('data-target');
                            
                            // For large numbers, start from 80% of target to make animation faster
                            // For small numbers (<=100), start from 0
                            const startValue = target > 100 ? Math.floor(target * 0.8) : 0;
                            
                            let startTime = null;

                            const updateCount = (currentTime) => {
                                if (!startTime) startTime = currentTime;
                                const elapsed = currentTime - startTime;
                                const progress = Math.min(elapsed / duration, 1);

                                // Easing function for smooth animation (easeOutExpo)
                                const easeOutExpo = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress);
                                
                                const currentValue = Math.floor(startValue + (target - startValue) * easeOutExpo);
                                counter.innerText = currentValue.toLocaleString();

                                if (progress < 1) {
                                    requestAnimationFrame(updateCount);
                                } else {
                                    counter.innerText = target.toLocaleString();
                                }
                            };

                            // Set initial value
                            counter.innerText = startValue.toLocaleString();
                            requestAnimationFrame(updateCount);
                        });
                    }

                    // Use Intersection Observer to trigger animation when in view
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                animateCounters();
                                observer.unobserve(entry.target); // Only animate once
                            }
                        });
                    }, { threshold: 0.5 });

                    const statsSection = document.querySelector('#statistik');
                    if (statsSection) {
                        observer.observe(statsSection);
                    }
                };

                // Initialize on load or immediately if ready (handles Livewire navigation)
                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', initStatsAnimation);
                } else {
                    initStatsAnimation();
                }
            })();
        </script>
    @endpush

    <!-- Pemerintahan Desa Section -->
    <section id="pemerintahan" class="py-20 bg-slate-50 dark:bg-slate-900 transition-colors duration-300">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <span class="text-primary font-semibold tracking-wider uppercase text-sm">Struktur Organisasi</span>
                <h2 class="text-3xl md:text-4xl font-bold text-slate-800 dark:text-white mt-2 mb-4">Pemerintahan Desa</h2>
                <div class="w-20 h-1.5 bg-primary mx-auto rounded-full"></div>
                <p class="text-slate-600 dark:text-slate-400 mt-4 max-w-2xl mx-auto">
                    Mengenal jajaran aparatur desa yang siap melayani masyarakat dengan sepenuh hati.
                </p>
            </div>

            <!-- Horizontal Scroll Container -->
            <div class="flex overflow-x-auto pb-8 gap-6 snap-x scrollbar-hide -mx-4 px-4 md:mx-0 md:px-0">
                @forelse($aparaturDesa as $aparatur)
                    <div class="min-w-[200px] md:min-w-[280px] snap-center">
                        <a href="{{ route('aparatur.detail', $aparatur->slug) }}"
                            class="block group bg-white dark:bg-slate-800 rounded-xl md:rounded-2xl p-4 md:p-6 shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 dark:border-slate-700 text-center hover:-translate-y-2 h-full">
                            <div class="relative w-20 h-20 md:w-32 md:h-32 mx-auto mb-3 md:mb-6">
                                <div
                                    class="absolute inset-0 bg-blue-100 dark:bg-blue-900/30 rounded-full transform rotate-6 group-hover:rotate-12 transition-transform duration-300">
                                </div>
                                @if($aparatur->foto)
                                    <img src="{{ asset('storage/' . $aparatur->foto) }}"
                                        alt="{{ $aparatur->nama }}"
                                        class="relative w-full h-full object-cover rounded-full border-2 md:border-4 border-white dark:border-slate-700 shadow-md">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($aparatur->nama) }}&color=7F9CF5&background=EBF4FF"
                                        alt="{{ $aparatur->nama }}"
                                        class="relative w-full h-full object-cover rounded-full border-2 md:border-4 border-white dark:border-slate-700 shadow-md">
                                @endif
                                <div class="absolute bottom-0 right-0 bg-primary text-white w-6 h-6 md:w-8 md:h-8 rounded-full flex items-center justify-center border-2 border-white dark:border-slate-700 shadow-sm"
                                    title="Verifikasi">
                                    <i class="fa-solid fa-check text-[10px] md:text-xs"></i>
                                </div>
                            </div>

                            <h3
                                class="text-base md:text-xl font-bold text-slate-800 dark:text-white mb-1 group-hover:text-primary transition-colors line-clamp-1">
                                {{ $aparatur->nama }}</h3>
                            <p class="text-primary font-medium mb-2 text-xs md:text-base line-clamp-2">{{ $aparatur->jabatan }}
                            </p>
                            @if($aparatur->nip)
                                <p
                                    class="text-[10px] md:text-xs text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-700/50 py-1 px-2 md:px-3 rounded-full inline-block mb-2 md:mb-4">
                                    NIP: {{ $aparatur->nip }}
                                </p>
                            @endif

                            <div
                                class="mt-2 md:mt-4 text-primary font-semibold text-xs md:text-sm opacity-0 group-hover:opacity-100 transition-opacity">
                                Lihat Profil <i class="fa-solid fa-arrow-right ml-1"></i>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="w-full text-center py-12">
                        <div
                            class="w-20 h-20 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fa-solid fa-users text-slate-400 text-3xl"></i>
                        </div>
                        <p class="text-slate-500 dark:text-slate-400">Data aparatur desa belum tersedia.</p>
                    </div>
                @endforelse
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('pemerintahan') }}" wire:navigate
                    class="inline-flex items-center gap-2 text-primary font-semibold hover:underline">
                    <span>Lihat Struktur Organisasi Lengkap</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Transparansi Anggaran Section -->
    @if(isset($tahunAnggaran) && $tahunAnggaran)
    <section id="anggaran" class="py-20 bg-slate-50 dark:bg-slate-900 transition-colors duration-300 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-5 dark:opacity-10 bg-[radial-gradient(#3b82f6_1px,transparent_1px)] [background-size:16px_16px]"></div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center mb-16">
                <span class="text-primary font-semibold tracking-wider uppercase text-sm">Transparansi Publik</span>
                <h2 class="text-3xl md:text-4xl font-bold text-slate-800 dark:text-white mt-2 mb-4">APBDes Tahun {{ $tahunAnggaran }}</h2>
                <div class="w-20 h-1.5 bg-primary mx-auto rounded-full"></div>
                <p class="text-slate-600 dark:text-slate-400 mt-4 max-w-2xl mx-auto">
                    Wujud komitmen transparansi pengelolaan keuangan desa kepada masyarakat.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <!-- Pendapatan -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-lg border-t-4 border-green-500 hover:transform hover:-translate-y-2 transition-all duration-300">
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-14 h-14 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center text-green-600 dark:text-green-400 text-2xl">
                            <i class="fa-solid fa-money-bill-trend-up"></i>
                        </div>
                        <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 text-xs font-bold uppercase rounded-full">Pendapatan</span>
                    </div>
                    <div class="text-slate-500 dark:text-slate-400 text-sm font-medium mb-1">Total Pendapatan</div>
                    <h3 class="text-2xl lg:text-3xl font-bold text-slate-800 dark:text-white">
                        Rp {{ number_format($anggaranPendapatan, 0, ',', '.') }}
                    </h3>
                    <div class="mt-4 w-full bg-slate-100 dark:bg-slate-700 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: 100%"></div>
                    </div>
                </div>

                <!-- Belanja -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-lg border-t-4 border-red-500 hover:transform hover:-translate-y-2 transition-all duration-300">
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-14 h-14 bg-red-100 dark:bg-red-900/30 rounded-xl flex items-center justify-center text-red-600 dark:text-red-400 text-2xl">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </div>
                        <span class="px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 text-xs font-bold uppercase rounded-full">Belanja</span>
                    </div>
                    <div class="text-slate-500 dark:text-slate-400 text-sm font-medium mb-1">Total Belanja</div>
                    <h3 class="text-2xl lg:text-3xl font-bold text-slate-800 dark:text-white">
                        Rp {{ number_format($anggaranBelanja, 0, ',', '.') }}
                    </h3>
                    <div class="mt-4 w-full bg-slate-100 dark:bg-slate-700 rounded-full h-2">
                        @php
                            $persenBelanja = $anggaranPendapatan > 0 ? ($anggaranBelanja / $anggaranPendapatan) * 100 : 0;
                        @endphp
                        <div class="bg-red-500 h-2 rounded-full" style="width: {{ min($persenBelanja, 100) }}%"></div>
                    </div>
                </div>

                <!-- Pembiayaan -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-lg border-t-4 border-blue-500 hover:transform hover:-translate-y-2 transition-all duration-300">
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-14 h-14 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center text-blue-600 dark:text-blue-400 text-2xl">
                            <i class="fa-solid fa-scale-balanced"></i>
                        </div>
                        <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-xs font-bold uppercase rounded-full">Pembiayaan</span>
                    </div>
                    <div class="text-slate-500 dark:text-slate-400 text-sm font-medium mb-1">Total Pembiayaan</div>
                    <h3 class="text-2xl lg:text-3xl font-bold text-slate-800 dark:text-white">
                        Rp {{ number_format($anggaranPembiayaan, 0, ',', '.') }}
                    </h3>
                    <div class="mt-4 w-full bg-slate-100 dark:bg-slate-700 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: 100%"></div>
                    </div>
                </div>
            </div>

            <!-- Optional: Detailed Button -->
            <div class="text-center mt-8">
                <a href="{{ route('anggaran-desa') }}" wire:navigate class="inline-flex items-center gap-2 bg-white dark:bg-slate-800 text-primary px-6 py-3 rounded-full font-bold shadow-md hover:shadow-lg transition-all hover:-translate-y-1">
                    <span>Lihat Rincian Anggaran</span>
                    <i class="fa-solid fa-chart-pie"></i>
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- Layanan Publik Section -->
    <section id="layanan"
        class="py-20 bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-slate-900 dark:to-slate-800 transition-colors duration-300">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <span class="text-primary font-semibold tracking-wider uppercase text-sm">Pelayanan Prima</span>
                <h2 class="text-3xl md:text-4xl font-bold text-slate-800 dark:text-white mt-2 mb-4">Layanan Publik Online
                </h2>
                <div class="w-20 h-1.5 bg-primary mx-auto rounded-full"></div>
                <p class="text-slate-600 dark:text-slate-400 mt-4 max-w-2xl mx-auto">
                    Akses mudah berbagai layanan administrasi desa secara online, cepat, dan transparan.
                </p>
            </div>

            <!-- Featured Service: Pengajuan Surat -->
            <div class="max-w-4xl mx-auto mb-12">
                <div class="bg-gradient-to-r from-blue-600 to-cyan-600 rounded-3xl shadow-2xl overflow-hidden">
                    <div class="grid md:grid-cols-2 gap-8 items-center p-8 md:p-12">
                        <div class="text-white">
                            <div
                                class="inline-block px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-semibold mb-4">
                                <i class="fa-solid fa-star text-yellow-300 mr-2"></i>Layanan Unggulan
                            </div>
                            <h3 class="text-3xl md:text-4xl font-bold mb-4">Pengajuan Surat Online</h3>
                            <p class="text-blue-100 mb-6 text-lg">
                                Ajukan berbagai jenis surat keterangan secara online tanpa perlu datang ke kantor desa.
                                Proses cepat, mudah, dan dapat dilacak statusnya.
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
                                    <span>Hemat Waktu & Biaya</span>
                                </li>
                            </ul>
                            <a href="/warga" wire:navigate
                                class="inline-flex items-center gap-3 bg-white text-blue-600 px-8 py-4 rounded-full font-bold text-lg hover:bg-blue-50 transition-all hover:scale-105 shadow-lg">
                                <i class="fa-solid fa-file-signature text-2xl"></i>
                                <span>Ajukan Surat Sekarang</span>
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                        <div class="hidden md:block">
                            <div class="relative">
                                <div class="absolute inset-0 bg-white/10 backdrop-blur-sm rounded-2xl transform rotate-6">
                                </div>
                                <div class="relative bg-white rounded-2xl p-8 shadow-2xl">
                                    <div class="space-y-4">
                                        <div class="flex items-center gap-4 p-4 bg-blue-50 rounded-xl">
                                            <div
                                                class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white">
                                                <i class="fa-solid fa-file-lines text-xl"></i>
                                            </div>
                                            <div class="flex-1">
                                                <div class="font-semibold text-slate-800">Surat Keterangan</div>
                                                <div class="text-sm text-slate-500">Domisili, Usaha, dll</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-4 p-4 bg-green-50 rounded-xl">
                                            <div
                                                class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center text-white">
                                                <i class="fa-solid fa-hand-holding-heart text-xl"></i>
                                            </div>
                                            <div class="flex-1">
                                                <div class="font-semibold text-slate-800">SKTM</div>
                                                <div class="text-sm text-slate-500">Tidak Mampu</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-4 p-4 bg-orange-50 rounded-xl">
                                            <div
                                                class="w-12 h-12 bg-orange-600 rounded-full flex items-center justify-center text-white">
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

            <!-- Other Services Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                @foreach($jenisSurat as $surat)
                    <a href="/warga" wire:navigate
                        class="group bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col items-center text-center border border-slate-100 dark:border-slate-700">
                        <div
                            class="w-16 h-16 bg-{{ $surat->display_color }}-50 dark:bg-{{ $surat->display_color }}-900/20 text-{{ $surat->display_color }}-600 rounded-2xl flex items-center justify-center text-2xl mb-4 group-hover:bg-{{ $surat->display_color }}-600 group-hover:text-white transition-colors duration-300">
                            <i class="fa-solid {{ $surat->display_icon }}"></i>
                        </div>
                        <h3
                            class="font-semibold text-slate-800 dark:text-white group-hover:text-{{ $surat->display_color }}-600 dark:group-hover:text-{{ $surat->display_color }}-400 transition-colors">
                            {{ $surat->nama_surat }}
                        </h3>
                    </a>
                @endforeach
            </div>

            <div class="text-center mt-8 mb-8">
                <a href="{{ route('layanan') }}" wire:navigate
                    class="inline-flex items-center gap-2 bg-primary hover:bg-blue-600 text-white px-8 py-3 rounded-full font-semibold shadow-lg transition-all hover:scale-105">
                    <span>Lihat Semua Layanan</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- UMKM Section -->
    <section id="umkm" class="py-20 bg-white dark:bg-dark transition-colors duration-300 overflow-hidden">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <span class="text-primary font-semibold tracking-wider uppercase text-sm">Ekonomi Kreatif</span>
                <h2 class="text-3xl md:text-4xl font-bold text-slate-800 dark:text-white mt-2">Produk Unggulan UMKM</h2>
                <div class="w-20 h-1.5 bg-primary mx-auto mt-4 rounded-full"></div>
            </div>

            <!-- Horizontal Scroll Container -->
            <div class="flex overflow-x-auto pb-8 gap-4 snap-x scrollbar-hide -mx-4 px-4">
                @forelse($featuredProducts as $product)
                    <div
                        class="min-w-[220px] md:min-w-[180px] lg:min-w-[200px] snap-center bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden group hover:shadow-xl transition-all duration-300">
                        <a href="{{ route('umkm.detail', $product->slug) }}" wire:navigate>
                            <div class="relative aspect-square overflow-hidden">
                                @if($product->gambar)
                                    <img data-src="{{ asset('storage/' . $product->gambar) }}"
                                        src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300'%3E%3C/svg%3E"
                                        alt="{{ $product->nama_produk }}"
                                        class="lazy-image w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                @else
                                    <div
                                        class="w-full h-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center">
                                        <i class="fa-solid fa-box text-white text-5xl"></i>
                                    </div>
                                @endif
                            </div>
                        </a>
                        <div class="p-5">
                            <div class="text-xs text-slate-500 dark:text-slate-400 mb-1">
                                {{ $product->kategoriUmkm->nama_kategori ?? 'Umum' }}</div>
                            <a href="{{ route('umkm.detail', $product->slug) }}" wire:navigate>
                                <h3
                                    class="text-lg font-bold text-slate-800 dark:text-white mb-2 line-clamp-2 hover:text-primary transition-colors">
                                    {{ $product->nama_produk }}</h3>
                            </a>
                            <div class="mb-3">
                                <span class="text-base font-bold text-primary">Rp
                                    {{ number_format($product->harga, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center gap-2 mb-4">
                                <span class="text-sm text-slate-600 dark:text-slate-300">{{ $product->nama_penjual }}</span>
                            </div>
                            <a href="{{ route('umkm.detail', $product->slug) }}" wire:navigate
                                class="w-full py-2.5 rounded-xl bg-primary text-white font-semibold hover:bg-blue-600 transition-colors flex items-center justify-center gap-2">
                                <i class="fa-solid fa-eye"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="w-full text-center py-12">
                        <i class="fa-solid fa-store text-gray-300 text-6xl mb-4"></i>
                        <p class="text-gray-500 text-lg">Belum ada produk UMKM</p>
                    </div>
                @endforelse
            </div>

            <div class="text-center mt-8">
                <a href="{{ route('umkm') }}" wire:navigate
                    class="inline-flex items-center gap-2 bg-primary hover:bg-blue-600 text-white px-8 py-3 rounded-full font-semibold shadow-lg transition-all hover:scale-105">
                    <span>Lihat Semua UMKM</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Berita Terkini Section -->
    <section id="berita" class="py-20 bg-slate-50 dark:bg-slate-900 transition-colors duration-300">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12">
                <div class="mb-6 md:mb-0">
                    <span class="text-primary font-semibold tracking-wider uppercase text-sm">Kabar Desa</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-slate-800 dark:text-white mt-2">Artikel Terbaru</h2>
                    <div class="w-20 h-1.5 bg-primary mt-4 rounded-full"></div>
                </div>
                <a href="{{ route('blog') }}" wire:navigate
                    class="px-6 py-3 bg-white dark:bg-slate-800 text-primary border border-primary/20 hover:bg-primary hover:text-white rounded-full font-semibold shadow-sm transition-all hover:scale-105 flex items-center gap-2">
                    <span>Lihat Semua Artikel</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                @forelse($latestNews as $index => $news)
                    @if($index === 0)
                        <!-- Main Featured News (Left Side) -->
                        <div class="lg:col-span-2 group">
                            <a href="{{ route('blog.detail', $news->slug) }}" wire:navigate
                                class="block h-full relative rounded-3xl overflow-hidden shadow-lg">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent z-10"></div>
                                <img src="{{ Str::startsWith($news->cover_photo_path, 'http') ? $news->cover_photo_path : asset('storage/' . $news->cover_photo_path) }}"
                                    alt="{{ $news->title }}"
                                    class="w-full h-[400px] lg:h-full object-cover transition-transform duration-700 group-hover:scale-110">

                                <div class="absolute bottom-0 left-0 p-6 md:p-8 z-20 w-full">
                                    <div class="flex items-center gap-4 text-white/80 text-sm mb-3">
                                        <span class="bg-primary px-3 py-1 rounded-full text-white text-xs font-bold">Terbaru</span>
                                        <span><i
                                                class="fa-regular fa-calendar mr-2"></i>{{ $news->published_at ? $news->published_at->format('d M Y') : $news->created_at->format('d M Y') }}</span>
                                    </div>
                                    <h3
                                        class="text-2xl md:text-4xl font-bold text-white mb-3 leading-tight group-hover:text-blue-300 transition-colors">
                                        {{ $news->title }}
                                    </h3>
                                    <p class="text-white/90 line-clamp-2 md:line-clamp-3 mb-4 max-w-2xl">
                                        {{ Str::limit(strip_tags($news->body), 150) }}
                                    </p>
                                    <span
                                        class="inline-flex items-center text-white font-semibold group-hover:translate-x-2 transition-transform">
                                        Baca Selengkapnya <i class="fa-solid fa-arrow-right ml-2"></i>
                                    </span>
                                </div>
                            </a>
                        </div>
                        <div class="space-y-6">
                    @else
                            <!-- Side News Items (Right Side) -->
                            <div
                                class="flex gap-4 group bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 hover:shadow-md transition-all">
                                <a href="{{ route('blog.detail', $news->slug) }}" wire:navigate
                                    class="shrink-0 w-24 h-24 md:w-32 md:h-32 rounded-xl overflow-hidden relative">
                                    <img src="{{ Str::startsWith($news->cover_photo_path, 'http') ? $news->cover_photo_path : asset('storage/' . $news->cover_photo_path) }}"
                                        alt="{{ $news->title }}"
                                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                </a>
                                <div class="flex flex-col justify-center">
                                    <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400 mb-2">
                                        <i class="fa-regular fa-calendar"></i>
                                        {{ $news->published_at ? $news->published_at->format('d M Y') : $news->created_at->format('d M Y') }}
                                    </div>
                                    <a href="{{ route('blog.detail', $news->slug) }}" wire:navigate>
                                        <h3
                                            class="text-base font-bold text-slate-800 dark:text-white line-clamp-2 group-hover:text-primary transition-colors mb-1">
                                            {{ $news->title }}
                                        </h3>
                                    </a>
                                    <a href="{{ route('blog.detail', $news->slug) }}" wire:navigate
                                        class="text-xs text-primary font-medium hover:underline mt-auto">
                                        Baca selengkapnya
                                    </a>
                                </div>
                            </div>
                        @endif

                        @if($loop->last)
                            </div> <!-- End of right column container -->
                        @endif
                @empty
                    <div class="col-span-full text-center py-12">
                        <i class="fa-solid fa-newspaper text-gray-300 text-6xl mb-4"></i>
                        <p class="text-gray-500 text-lg">Belum ada artikel terbaru</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Galeri Section -->
    <section id="galeri" class="py-20 bg-white dark:bg-dark transition-colors duration-300">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12">
                <div class="mb-6 md:mb-0">
                    <span class="text-primary font-semibold tracking-wider uppercase text-sm">Dokumentasi</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-slate-800 dark:text-white mt-2">Galeri Kegiatan</h2>
                    <div class="w-20 h-1.5 bg-primary mt-4 rounded-full"></div>
                </div>
                <a href="{{ route('galeri') }}" wire:navigate
                    class="px-6 py-3 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-primary hover:text-white rounded-full font-semibold shadow-sm transition-all hover:scale-105 flex items-center gap-2">
                    <span>Lihat Semua Galeri</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <!-- Masonry Grid -->
            <div class="columns-2 md:columns-3 lg:columns-4 gap-4 space-y-4">
                @forelse($galleries as $gallery)
                    <div class="break-inside-avoid group relative rounded-2xl overflow-hidden bg-slate-100 dark:bg-slate-800 cursor-pointer hover:shadow-xl transition-all duration-300 hover:-translate-y-1"
                        onclick="openGalleryModal('{{ asset('storage/' . $gallery->gambar) }}', '{{ $gallery->judul }}', '{{ $gallery->kategori }}', '{{ $gallery->tanggal_kegiatan ? $gallery->tanggal_kegiatan->format('d M Y') : '' }}', `{{ $gallery->deskripsi }}`)">

                        <img src="{{ asset('storage/' . $gallery->gambar) }}"
                            alt="{{ $gallery->judul }}"
                            class="w-full h-auto object-cover transform transition-transform duration-700 group-hover:scale-110">

                        <!-- Overlay -->
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-4">
                            <span
                                class="inline-block px-2 py-0.5 bg-primary/90 text-white text-[10px] font-bold rounded-full w-fit mb-1 backdrop-blur-sm">
                                {{ $gallery->kategori }}
                            </span>
                            <h3 class="text-white font-bold text-sm leading-tight mb-0.5 line-clamp-2">{{ $gallery->judul }}
                            </h3>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <i class="fa-solid fa-images text-gray-300 text-6xl mb-4"></i>
                        <p class="text-gray-500 text-lg">Belum ada galeri</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Gallery Modal -->
        <div id="gallery-modal" onclick="if(event.target === this) closeGalleryModal()"
            class="fixed inset-0 z-[9999] bg-black/90 backdrop-blur-md hidden opacity-0 transition-opacity duration-300 flex items-center justify-center p-4">
            <button onclick="closeGalleryModal()"
                class="absolute top-6 right-6 text-white/70 hover:text-white transition-colors z-50">
                <i class="fa-solid fa-xmark text-4xl"></i>
            </button>

            <div class="relative w-full max-w-5xl h-[90vh] md:h-auto md:max-h-[90vh] flex flex-col md:flex-row bg-slate-900 rounded-3xl overflow-hidden shadow-2xl transform scale-95 transition-transform duration-300"
                id="gallery-modal-content">

                <!-- Image Container -->
                <div
                    class="w-full md:w-2/3 h-[40vh] md:h-[80vh] bg-black flex items-center justify-center relative group shrink-0">
                    <img id="modal-image" src="" alt="" class="max-w-full max-h-full object-contain">
                </div>

                <!-- Info Container -->
                <div
                    class="w-full md:w-1/3 bg-white dark:bg-slate-800 p-6 md:p-8 flex flex-col flex-1 md:flex-none md:h-[80vh] overflow-y-auto">
                    <div class="mb-6 shrink-0">
                        <span id="modal-category"
                            class="inline-block px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-primary text-xs font-bold rounded-full mb-3"></span>
                        <h2 id="modal-title"
                            class="text-xl md:text-2xl font-bold text-slate-800 dark:text-white mb-2 leading-tight"></h2>
                        <p id="modal-date" class="text-slate-500 dark:text-slate-400 text-sm flex items-center gap-2">
                            <i class="fa-regular fa-calendar"></i> <span></span>
                        </p>
                    </div>

                    <div
                        class="prose dark:prose-invert max-w-none text-slate-600 dark:text-slate-300 text-sm leading-relaxed flex-grow overflow-y-auto">
                        <p id="modal-description"></p>
                    </div>

                    <div class="mt-8 pt-6 border-t border-slate-100 dark:border-slate-700 shrink-0">
                        <button onclick="closeGalleryModal()"
                            class="w-full py-3 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-xl font-semibold hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors">
                            Tutup Galeri
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Gallery Modal Logic - Robust for Livewire
            (function () {
                window.openGalleryModal = function (imageSrc, title, category, date, description) {
                    const modal = document.getElementById('gallery-modal');
                    const content = document.getElementById('gallery-modal-content');
                    const img = document.getElementById('modal-image');
                    const titleEl = document.getElementById('modal-title');
                    const catEl = document.getElementById('modal-category');
                    const dateEl = document.getElementById('modal-date').querySelector('span');
                    const descEl = document.getElementById('modal-description');

                    if (!modal || !content || !img) return;

                    img.src = imageSrc;
                    if (titleEl) titleEl.textContent = title;
                    if (catEl) catEl.textContent = category;
                    if (dateEl) dateEl.textContent = date;
                    if (descEl) descEl.innerHTML = description || 'Tidak ada deskripsi.';

                    modal.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');

                    // Use requestAnimationFrame for smoother transition
                    requestAnimationFrame(() => {
                        modal.classList.remove('opacity-0');
                        content.classList.remove('scale-95');
                        content.classList.add('scale-100');
                    });
                };

                window.closeGalleryModal = function () {
                    const modal = document.getElementById('gallery-modal');
                    const content = document.getElementById('gallery-modal-content');
                    const img = document.getElementById('modal-image');

                    if (!modal || !content) return;

                    modal.classList.add('opacity-0');
                    content.classList.remove('scale-100');
                    content.classList.add('scale-95');

                    setTimeout(() => {
                        modal.classList.add('hidden');
                        document.body.classList.remove('overflow-hidden');
                        if (img) img.src = '';
                    }, 300);
                };

                // Handle Escape key
                if (window.galleryEscapeHandler) {
                    document.removeEventListener('keydown', window.galleryEscapeHandler);
                }
                window.galleryEscapeHandler = (e) => {
                    const modal = document.getElementById('gallery-modal');
                    if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
                        window.closeGalleryModal();
                    }
                };
                document.addEventListener('keydown', window.galleryEscapeHandler);
            })();
        </script>
    </section>
@endsection
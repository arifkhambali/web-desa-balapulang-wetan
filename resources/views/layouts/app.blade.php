<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', ($identitasDesa->nama_desa ?? 'Desa Tundagan') . ' - Website Resmi Pemerintah Desa')</title>
    <meta name="description"
        content="Website Resmi Pemerintah {{ $identitasDesa->nama_desa ?? 'Desa Tundagan' }}, Kecamatan Watukumpul, Kabupaten Pemalang.">
    
    <!-- PWA Settings -->
    <meta name="theme-color" content="#2563eb">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="WebDesa">
    <link rel="apple-touch-icon" href="{{ $identitasDesa && $identitasDesa->logo ? asset('storage/' . $identitasDesa->logo) : asset('logo-pwa-192.png') }}">
    <link rel="icon" href="{{ $identitasDesa && $identitasDesa->logo ? asset('storage/' . $identitasDesa->logo) : asset('favicon.ico') }}">
    <link rel="manifest" href="/manifest.json">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <!-- Livewire Styles -->
    @livewireStyles

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: '#2563eb',
                        secondary: '#1e40af',
                        dark: '#0f172a',
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.8s ease-out forwards',
                        'fade-in': 'fadeIn 1s ease-out forwards',
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .dark ::-webkit-scrollbar-track {
            background: #1e293b;
        }

        .dark ::-webkit-scrollbar-thumb {
            background: #475569;
        }

        .dark ::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }

        /* Glass Nav Effect */
        .glass-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .dark .glass-nav {
            background: rgba(15, 23, 42, 0.95);
        }

        /* Scrollbar Hide */
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        /* Prose Line Clamp */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
    @stack('styles')
    <script>
        // Initialize theme immediately to prevent FOUC
        if (localStorage.theme === 'dark' || (!('theme' in localStorage))) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="font-sans text-slate-800 bg-slate-50 dark:bg-dark dark:text-slate-100 transition-colors duration-300">

    @include('components.navbar')

    <!-- Main Content -->
    <!-- Main Content -->
    @if(isset($slot))
        {{ $slot }}
    @else
        @yield('content')
    @endif

    @include('components.footer')

    <!-- Scripts -->
    @include('components.scripts')

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!-- Initialize Footer Map -->
    <script>
        function initFooterMap() {
            const footerMapContainer = document.getElementById('footer-map');
            if (!footerMapContainer) return;

            // CRITICAL FIX: If map container already has a Leaflet ID, remove it
            // This happens when Livewire navigates but keep the same footer element
            if (footerMapContainer._leaflet_id !== undefined && footerMapContainer._leaflet_id !== null) {
                console.log('Cleaning up existing map container...');
                // If we also have the instance, remove it properly
                if (window.footerMapInstance) {
                    window.footerMapInstance.remove();
                    window.footerMapInstance = null;
                }
                // Force clear the leaflet ID just in case remove() missed it
                footerMapContainer._leaflet_id = null;
                footerMapContainer.innerHTML = ''; // Clear container content
            }

            @if($identitasDesa && $identitasDesa->latitude && $identitasDesa->longitude)
                try {
                    console.log('Initializing footer map...');
                    window.footerMapInstance = L.map('footer-map', {
                        zoomControl: false, 
                        scrollWheelZoom: false,
                        dragging: false,
                        touchZoom: false
                    }).setView([{{ $identitasDesa->latitude }}, {{ $identitasDesa->longitude }}], 13);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '© OpenStreetMap'
                    }).addTo(window.footerMapInstance);

                    L.marker([{{ $identitasDesa->latitude }}, {{ $identitasDesa->longitude }}]).addTo(window.footerMapInstance);
                } catch (e) {
                    console.error('Leaflet Init Error:', e);
                }
            @endif
        }

        // Initialize on load
        document.addEventListener('DOMContentLoaded', initFooterMap);

        // Re-initialize on Livewire navigation
        document.addEventListener('livewire:navigated', () => {
            setTimeout(initFooterMap, 100);
        });
    </script>

    <!-- Livewire Scripts -->
    @livewireScripts

    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            window.initLazyLoad = function () {
                const images = document.querySelectorAll('img[data-src]:not(.loaded)');

                if ('IntersectionObserver' in window) {
                    const imageObserver = new IntersectionObserver((entries, observer) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                const img = entry.target;
                                img.src = img.dataset.src;
                                img.classList.add('loaded');
                                observer.unobserve(img);
                            }
                        });
                    });

                    images.forEach(img => imageObserver.observe(img));
                } else {
                    // Fallback for browsers without IntersectionObserver
                    images.forEach(img => {
                        img.src = img.dataset.src;
                        img.classList.add('loaded');
                    });
                }
            };

            // Initialize on load
            window.initLazyLoad();

            // Initialize on Livewire navigation
            document.addEventListener('livewire:navigated', () => {
                window.initLazyLoad();
            });
        });

        // --- PWA Service Worker Registration ---
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(reg => console.log('SW Registered', reg))
                    .catch(err => console.error('SW Registration Failed', err));
            });
        }

        // --- PWA Install Prompt Logic ---
        let deferredPrompt;
        const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
        const isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone;

        console.log('PWA Check:', { isIOS, isStandalone });

        if (!isStandalone) {
            // Android/Chrome/Desktop event
            window.addEventListener('beforeinstallprompt', (e) => {
                e.preventDefault();
                deferredPrompt = e;
                console.log('beforeinstallprompt event fired');
                showInstallPromotion('android');
            });

            // FORCE SHOW banner after 3 seconds for testing
            // This ensures user sees IT even if browser criteria isn't 100% met yet
            setTimeout(() => {
                if (!document.getElementById('pwa-install-banner')) {
                    if (isIOS) {
                        showInstallPromotion('ios');
                    } else {
                        // Show "android/generic" if event hasn't fired yet
                        // The "Install" button will only work if deferredPrompt exists, 
                        // but at least the banner is visible.
                        showInstallPromotion('android');
                    }
                }
            }, 3000);
        }

        function showInstallPromotion(platform) {
            // TEMP: Disable session check for testing to make sure it always appears
            // if (sessionStorage.getItem('pwa-banner-closed')) return;
            if (document.getElementById('pwa-install-banner')) return;

            const installBanner = document.createElement('div');
            installBanner.id = 'pwa-install-banner';
            installBanner.className = 'fixed bottom-4 left-4 right-4 z-[9999] bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-2xl border border-primary/20 flex flex-col gap-3 md:max-w-sm animate-fade-in-up';
            
            let actionHtml = '';
            if (platform === 'android') {
                actionHtml = `
                    <button id="install-pwa-btn" class="w-full bg-primary hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-xl text-sm transition-colors shadow-lg shadow-blue-500/30">
                        Instal Sekarang
                    </button>
                `;
            } else if (platform === 'ios') {
                actionHtml = `
                    <div class="text-[10px] text-slate-500 dark:text-slate-400 bg-slate-50 dark:bg-slate-900/50 p-2 rounded-lg border border-slate-100 dark:border-slate-700">
                        <p class="flex items-center gap-1 mb-1 font-medium">Cara instal di iPhone:</p>
                        <ol class="list-decimal list-inside space-y-0.5">
                            <li>Klik ikon <i class="fa-solid fa-arrow-up-from-bracket text-primary"></i> (Share)</li>
                            <li>Scroll ke bawah, pilih <b>"Add to Home Screen"</b></li>
                        </ol>
                    </div>
                `;
            }

            installBanner.innerHTML = `
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center text-primary flex-shrink-0">
                        <img src="{{ $identitasDesa && $identitasDesa->logo ? asset('storage/' . $identitasDesa->logo) : asset('logo-pwa-192.png') }}" class="w-10 h-10 rounded-lg object-contain">
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-sm text-slate-800 dark:text-white leading-tight">Install Aplikasi Desa</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Akses lebih cepat & mudah dari layar HP Anda</p>
                    </div>
                    <button id="close-pwa-banner" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 p-1">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>
                ${actionHtml}
            `;
            document.body.appendChild(installBanner);

            if (platform === 'android') {
                document.getElementById('install-pwa-btn').addEventListener('click', async () => {
                    if (deferredPrompt) {
                        deferredPrompt.prompt();
                        const { outcome } = await deferredPrompt.userChoice;
                        console.log(`User responded to the install prompt: ${outcome}`);
                        deferredPrompt = null;
                        installBanner.remove();
                    }
                });
            }

            document.getElementById('close-pwa-banner').addEventListener('click', () => {
                installBanner.remove();
                sessionStorage.setItem('pwa-banner-closed', 'true');
            });
        }

        window.addEventListener('appinstalled', (event) => {
            console.log('PWA was installed');
            const banner = document.getElementById('pwa-install-banner');
            if (banner) banner.remove();
        });
    </script>
</body>

</html>
<header x-data="{ 
    mobileMenuOpen: false,
    scrolled: false,
    init() {
        window.addEventListener('scroll', () => {
            this.scrolled = window.scrollY > 20;
            if(this.mobileMenuOpen) this.mobileMenuOpen = false;
        });
    }
}" class="relative z-50">

    <nav id="navbar"
        class="fixed w-full z-50 transition-all duration-300 py-3 md:py-5 glass-nav shadow-sm bg-white/70 dark:bg-slate-900/60 backdrop-blur-md">
        <div class="max-w-screen-2xl mx-auto px-4 md:px-6 lg:px-8">
            <div class="flex justify-between items-center">

                <!-- LOGO + NAMA DESA -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    @if($identitasDesa && $identitasDesa->logo)
                        <img src="{{ asset('storage/' . $identitasDesa->logo) }}"
                            class="w-8 h-8 md:w-10 md:h-10 object-contain group-hover:scale-110 transition-transform duration-300">
                    @else
                        <div
                            class="w-8 h-8 md:w-10 md:h-10 bg-primary rounded-full flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fa-solid fa-landmark"></i>
                        </div>
                    @endif

                    <div class="flex flex-col leading-none">
                        <span
                            class="text-xs md:text-sm font-bold uppercase tracking-wider text-primary dark:text-blue-400">
                            {{ $identitasDesa->nama_desa ?? 'Desa Tundagan' }}
                        </span>
                        <span class="hidden xl:block text-[9px] md:text-[10px] text-slate-600 dark:text-slate-400">
                            Kec. Watukumpul, Kab. Pemalang
                        </span>
                    </div>
                </a>

                <!-- DESKTOP NAV -->
                <div
                    class="hidden lg:flex items-center gap-0.5 bg-white/10 dark:bg-black/10 backdrop-blur-md px-2 py-1.5 rounded-full border border-white/20 dark:border-white/5">
                    @php
                        $menus = [
                            '/' => 'Beranda',
                            'profil' => 'Profil Desa',
                            'layanan' => 'Layanan',
                            'blog' => 'Kabar Desa',
                            'galeri' => 'Galeri',
                            'umkm' => 'Potensi',
                            'informasi-publik' => 'Informasi Publik',
                            'anggaran-desa' => 'Transparansi',
                        ];
                    @endphp

                    @foreach($menus as $slug => $label)
                        <a href="{{ $slug === '/' ? route('home') : route($slug) }}" wire:navigate class="nav-link px-3 py-2 text-[13px] font-medium rounded-full
                                                         {{ Request::is($slug . '*') ? 'bg-primary/10 text-primary' : 'hover:bg-primary/10 hover:text-primary dark:hover:text-blue-400' }}
                                                         transition-colors whitespace-nowrap">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>

                <!-- BUTTONS -->
                <div class="flex items-center gap-2 md:gap-3">
                    @auth
                        <a href="{{ Auth::user()->role === 'warga' ? '/warga' : '/admin' }}"
                            class="hidden md:inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-primary hover:bg-blue-700 rounded-full transition-colors shadow-sm shadow-blue-500/30">
                            Dashboard
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="hidden md:block">
                            @csrf
                            <button type="submit"
                                class="w-8 h-8 md:w-9 md:h-9 rounded-full bg-red-50 dark:bg-red-900/20 flex items-center justify-center text-red-500 hover:bg-red-100 dark:hover:bg-red-900/40 transition-colors"
                                title="Keluar">
                                <i class="fa-solid fa-right-from-bracket"></i>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" wire:navigate
                            class="hidden md:inline-flex items-center justify-center px-5 py-2 text-sm font-medium text-white bg-primary hover:bg-blue-700 rounded-full transition-colors shadow-lg shadow-blue-500/30 hover:-translate-y-0.5 transform duration-200">
                            <i class="fa-solid fa-right-to-bracket mr-2"></i> Masuk
                        </a>
                    @endauth
                    <button id="theme-toggle"
                        class="w-8 h-8 md:w-9 md:h-9 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-yellow-400 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                        <i class="fa-solid fa-sun hidden dark:block"></i>
                        <i class="fa-solid fa-moon dark:hidden"></i>
                    </button>

                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="lg:hidden w-8 h-8 md:w-9 md:h-9 rounded-full bg-white/90 dark:bg-slate-800 flex items-center justify-center text-slate-800 dark:text-slate-200 shadow">
                        <i class="fa-solid fa-bars text-base md:text-lg"></i>
                    </button>
                </div>

            </div>
        </div>
    </nav>

    <!-- MOBILE MENU WRAPPER -->
    <div class="lg:hidden">
        <!-- BACKDROP -->
        <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="mobileMenuOpen = false"
            class="fixed inset-0 z-[99999] bg-black/50 backdrop-blur-sm cursor-pointer" style="touch-action: none;" style="display: none;">
        </div>

        <!-- DRAWER -->
        <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full" @click.outside="mobileMenuOpen = false"
            class="fixed top-0 right-0 bottom-0 w-[280px] z-[100000] bg-white dark:bg-slate-900 shadow-2xl flex flex-col" style="display: none;">

            <!-- HEADER -->
            <div class="p-5 flex items-center justify-between border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-2">
                    @if($identitasDesa && $identitasDesa->logo)
                        <img src="{{ asset('storage/' . $identitasDesa->logo) }}" class="w-8 h-8 object-contain">
                    @else
                        <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white">
                            <i class="fa-solid fa-landmark text-xs"></i>
                        </div>
                    @endif
                    <span class="font-bold text-slate-800 dark:text-white text-sm">Menu Utama</span>
                </div>
                <button @click="mobileMenuOpen = false"
                    class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:bg-red-100 hover:text-red-500 transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- MENU ITEMS -->
            <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
                @foreach($menus as $slug => $label)
                    <a href="{{ $slug === '/' ? route('home') : route($slug) }}" wire:navigate
                        @click="mobileMenuOpen = false"
                        class="block px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200
                                                {{ Request::is($slug . '*') ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 hover:translate-x-1' }}">
                        {{ $label }}
                    </a>
                @endforeach

                <div class="pt-4 mt-4 border-t border-slate-100 dark:border-slate-800">
                    @auth
                        <a href="{{ Auth::user()->role === 'warga' ? '/warga' : '/admin' }}"
                            class="block px-4 py-3 rounded-xl text-sm font-medium text-primary bg-primary/10 hover:bg-primary/20 transition-colors mb-2">
                            <i class="fa-solid fa-gauge mr-2"></i> Dashboard
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-3 rounded-xl text-sm font-medium text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                <i class="fa-solid fa-right-from-bracket mr-2"></i> Keluar
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" wire:navigate
                            class="block px-4 py-3 rounded-xl text-sm font-medium text-white bg-primary hover:bg-blue-700 transition-colors text-center shadow-lg shadow-blue-500/30">
                            <i class="fa-solid fa-right-to-bracket mr-2"></i> Masuk
                        </a>
                    @endauth
                </div>

            </div>

            <!-- FOOTER -->
            <div class="p-5 border-t border-slate-100 dark:border-slate-800">
                <div class="text-xs text-center text-slate-400">
                    &copy; {{ date('Y') }} {{ $identitasDesa->nama_desa ?? 'Desa Tundagan' }}
                </div>
            </div>

        </div>
    </div>
</header>
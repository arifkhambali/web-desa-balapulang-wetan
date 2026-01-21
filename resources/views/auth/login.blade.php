@extends('layouts.app')

@section('title', 'Masuk - ' . ($identitasDesa->nama_desa ?? 'Desa Tundagan'))

@section('content')
<section class="min-h-screen flex items-stretch relative overflow-hidden bg-white dark:bg-slate-900">
    
    <!-- Left Side: Visual & Branding (Hidden on mobile) -->
    <div class="hidden lg:flex lg:w-3/5 relative bg-slate-900 items-center justify-center overflow-hidden">
        <!-- Background Image with Parallax Effect -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=2832&auto=format&fit=crop" 
                 alt="Suasana Desa" 
                 class="w-full h-full object-cover opacity-60 animate-ken-burns">
            <div class="absolute inset-0 bg-gradient-to-tr from-blue-900/90 via-slate-900/50 to-transparent"></div>
        </div>

        <!-- Content Overlay -->
        <div class="relative z-10 text-white p-12 max-w-2xl animate-fade-in-up">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-xl flex items-center justify-center border border-white/20 shadow-lg">
                    <i class="fa-solid fa-landmark text-2xl text-blue-300"></i>
                </div>
                <span class="text-xl font-bold tracking-wide uppercase text-blue-200">Sistem Informasi Desa</span>
            </div>
            
            <h1 class="text-5xl font-extrabold leading-tight mb-6 drop-shadow-lg">
                Selamat Datang di <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300">
                    {{ $identitasDesa->nama_desa ?? 'Desa Tundagan' }}
                </span>
            </h1>
            
            <p class="text-lg text-slate-300 leading-relaxed mb-8 border-l-4 border-blue-500 pl-4">
                "{{ $identitasDesa->misi ? Str::limit(strip_tags($identitasDesa->misi), 100) : 'Mewujudkan desa yang mandiri, sejahtera, dan berbudaya melalui pelayanan publik yang prima.' }}"
            </p>

            <div class="flex gap-4 mt-12">
                <div class="flex -space-x-4">
                    @foreach($latestWarga as $warga)
                        <img class="w-10 h-10 rounded-full border-2 border-slate-800 bg-slate-700 object-cover" 
                             src="https://ui-avatars.com/api/?name={{ urlencode($warga->nama_lengkap) }}&background=random&color=fff" 
                             alt="{{ $warga->nama_lengkap }}"
                             title="{{ $warga->nama_lengkap }}">
                    @endforeach
                </div>
                <div class="flex flex-col justify-center">
                    <span class="text-sm font-bold text-white">
                        @if($totalPenduduk > 1000)
                            {{ number_format($totalPenduduk / 1000, 1) }}k++
                        @else
                            {{ number_format($totalPenduduk) }}
                        @endif
                        Warga Terdaftar
                    </span>
                    <span class="text-xs text-slate-400">Bergabunglah bersama kami</span>
                </div>
            </div>
        </div>

        <!-- Decorative Shapes -->
        <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-slate-900 to-transparent z-10"></div>
    </div>

    <!-- Right Side: Login Form -->
    <div class="w-full lg:w-2/5 flex items-center justify-center p-8 lg:p-16 relative bg-white dark:bg-slate-950 pt-24 lg:pt-16">
        <!-- Mobile Background (Visible only on mobile) -->
        <div class="absolute inset-0 lg:hidden z-0">
             <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=1000&auto=format&fit=crop" 
                 class="w-full h-full object-cover opacity-10">
             <div class="absolute inset-0 bg-gradient-to-b from-white/90 via-white/95 to-white dark:from-slate-950/90 dark:to-slate-950"></div>
        </div>

        <div class="w-full max-w-md relative z-10 animate-fade-in-right">
            <!-- Mobile Logo -->
            <div class="lg:hidden text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-blue-600 text-white shadow-lg shadow-blue-500/30 mb-4">
                    <i class="fa-solid fa-landmark text-3xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white">{{ $identitasDesa->nama_desa ?? 'Desa Tundagan' }}</h2>
            </div>

            <div class="mb-10">
                <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">Halo, Warga! 👋</h2>
                <p class="text-slate-500 dark:text-slate-400">Silakan masukkan akun Anda untuk mengakses layanan desa.</p>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="group">
                    <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2 group-focus-within:text-blue-600 transition-colors">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-regular fa-envelope text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                        </div>
                        <input type="email" name="email" id="email" required autofocus
                            class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all shadow-sm hover:border-blue-300"
                            placeholder="nama@email.com" value="{{ old('email') }}">
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1 flex items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="group">
                    <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2 group-focus-within:text-blue-600 transition-colors">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-solid fa-lock text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                        </div>
                        <input type="password" name="password" id="password" required
                            class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all shadow-sm hover:border-blue-300"
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <div class="relative flex items-center">
                            <input type="checkbox" name="remember" class="peer h-5 w-5 cursor-pointer appearance-none rounded-md border border-slate-300 transition-all checked:border-blue-500 checked:bg-blue-500 hover:border-blue-400">
                            <div class="pointer-events-none absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-white opacity-0 transition-opacity peer-checked:opacity-100">
                                <i class="fa-solid fa-check text-xs"></i>
                            </div>
                        </div>
                        <span class="text-sm text-slate-600 dark:text-slate-400">Ingat saya</span>
                    </label>
                    <!-- <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline">Lupa password?</a> -->
                </div>

                <button type="submit" class="w-full py-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 transition-all transform hover:-translate-y-0.5 active:scale-[0.98] flex items-center justify-center gap-2">
                    <span>Masuk Sekarang</span>
                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                </button>
            </form>

            <div class="mt-10 pt-6 border-t border-slate-100 dark:border-slate-800 text-center">
                <p class="text-slate-500 dark:text-slate-400 mb-4">Belum punya akun? Silahkan Hubungi admin Desa</p>
                <!-- <a href="#" class="inline-flex items-center justify-center w-full py-3.5 px-4 rounded-xl border-2 border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 font-semibold hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
                    Daftar sebagai Warga Baru
                </a> -->
                
                <div class="mt-8">
                    <a href="{{ route('home') }}" wire:navigate class="inline-flex items-center gap-2 text-sm text-slate-400 hover:text-blue-600 transition-colors">
                        <i class="fa-solid fa-arrow-left"></i>
                        Kembali ke Halaman Utama
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    @keyframes ken-burns {
        0% { transform: scale(1); }
        100% { transform: scale(1.1); }
    }
    .animate-ken-burns {
        animation: ken-burns 20s ease-out infinite alternate;
    }
    @keyframes fade-in-right {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }
    .animate-fade-in-right {
        animation: fade-in-right 0.8s ease-out forwards;
    }
</style>
@endsection

@extends('layouts.app')

@section('title', 'Halaman Tidak Ditemukan - ' . ($identitasDesa->nama_desa ?? 'Desa Tundagan'))

@section('content')
<section class="min-h-screen flex items-center justify-center relative bg-gradient-to-br from-blue-600 to-cyan-600 text-white overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
    
    <div class="container mx-auto px-4 relative z-10 text-center">
        <div class="relative mb-8 animate-fade-in-up">
            <h1 class="text-9xl font-extrabold text-white/20 select-none">404</h1>
            <div class="absolute inset-0 flex items-center justify-center">
                <i class="fa-solid fa-triangle-exclamation text-6xl md:text-8xl text-white drop-shadow-lg"></i>
            </div>
        </div>
        
        <h2 class="text-3xl md:text-4xl font-bold mb-4 animate-fade-in-up [animation-delay:200ms]">Halaman Tidak Ditemukan</h2>
        <p class="text-lg text-blue-100 max-w-lg mx-auto mb-10 animate-fade-in-up [animation-delay:400ms]">
            Maaf, halaman yang Anda cari tidak dapat ditemukan. Mungkin halaman telah dipindahkan atau dihapus.
        </p>
        
        <a href="{{ route('home') }}" wire:navigate class="inline-flex items-center gap-2 px-8 py-4 bg-white text-primary font-bold rounded-full hover:bg-blue-50 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 animate-fade-in-up [animation-delay:600ms]">
            <i class="fa-solid fa-home"></i>
            Kembali ke Beranda
        </a>
    </div>
</section>
@endsection

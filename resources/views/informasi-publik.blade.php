@extends('layouts.app')

@section('title', 'Informasi Publik - ' . ($identitasDesa->nama_desa ?? 'Desa Tundagan'))

@section('description', 'Transparansi informasi publik Desa ' . ($identitasDesa->nama_desa ?? 'Maju Jaya') . '. Lihat dan unduh dokumen penting secara gratis.')

@section('content')
<!-- Hero Section -->
<section class="relative pt-32 pb-20 bg-slate-50 dark:bg-slate-900 overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#3b82f6_1px,transparent_1px)] [background-size:16px_16px]"></div>

    <div class="container mx-auto px-4 relative z-10 text-center">
        <span class="text-primary font-semibold tracking-wider uppercase text-sm animate-fade-in-up">IPID DESA</span>
        <h1 class="text-4xl md:text-6xl font-bold text-slate-800 dark:text-white mt-2 mb-6 animate-fade-in-up">
            Informasi Publik
        </h1>
        <p class="text-lg md:text-xl text-slate-600 dark:text-slate-400 max-w-2xl mx-auto animate-fade-in-up [animation-delay:200ms]">
            Transparansi informasi publik {{ $identitasDesa->nama_desa ?? 'Maju Jaya' }}. Lihat dan unduh dokumen penting secara gratis.
        </p>
    </div>
</section>

<!-- Main Content -->
<section class="py-20 bg-slate-50 dark:bg-slate-900 transition-colors duration-300">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            
            <!-- Livewire Table Component -->
            @livewire('informasi-publik-table')

        </div>
    </div>
</section>
@endsection

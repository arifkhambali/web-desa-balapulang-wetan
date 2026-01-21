<div>
    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 bg-slate-50 dark:bg-slate-900 overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#3b82f6_1px,transparent_1px)] [background-size:16px_16px]"></div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center mb-12">
                <span class="text-primary font-semibold tracking-wider uppercase text-sm">Transparansi Publik</span>
                <h1 class="text-4xl md:text-5xl font-bold text-slate-800 dark:text-white mt-2 mb-4">Anggaran Pendapatan & Belanja Desa</h1>
                <p class="text-slate-600 dark:text-slate-400 max-w-2xl mx-auto text-lg">
                    Rincian pelaksanaan APBDes Tahun Anggaran {{ $tahun }} sebagai wujud keterbukaan informasi publik.
                </p>
            </div>

            <!-- Filter Tahun -->
            <div class="flex justify-center mb-12">
                <div class="bg-white dark:bg-slate-800 p-2 rounded-full shadow-lg border border-slate-100 dark:border-slate-700 flex items-center gap-2">
                    <div class="pl-4 text-slate-500 font-medium">Tahun Anggaran:</div>
                    <select wire:model.live="tahun" class="bg-slate-50 dark:bg-slate-700 text-slate-800 dark:text-white font-bold py-2 px-6 rounded-full border-none focus:ring-2 focus:ring-primary cursor-pointer outline-none appearance-none">
                        @foreach($availableYears as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                        @if($availableYears->isEmpty())
                            <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                        @endif
                    </select>
                    <div wire:loading wire:target="tahun" class="pr-2 text-primary animate-spin">
                        <i class="fa-solid fa-circle-notch"></i>
                    </div>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <!-- Pendapatan -->
                <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border-l-4 border-green-500">
                    <div class="text-slate-500 dark:text-slate-400 text-sm font-medium mb-1">Total Pendapatan</div>
                    <div class="text-2xl font-bold text-slate-800 dark:text-white">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                </div>

                <!-- Belanja -->
                <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border-l-4 border-red-500">
                    <div class="text-slate-500 dark:text-slate-400 text-sm font-medium mb-1">Total Belanja</div>
                    <div class="text-2xl font-bold text-slate-800 dark:text-white">Rp {{ number_format($totalBelanja, 0, ',', '.') }}</div>
                </div>

                <!-- Surplus/Defisit -->
                @php
                    $surplus = $totalPendapatan - $totalBelanja;
                    $isSurplus = $surplus >= 0;
                @endphp
                <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border-l-4 {{ $isSurplus ? 'border-blue-500' : 'border-orange-500' }}">
                    <div class="text-slate-500 dark:text-slate-400 text-sm font-medium mb-1">{{ $isSurplus ? 'Surplus' : 'Defisit' }}</div>
                    <div class="text-2xl font-bold {{ $isSurplus ? 'text-blue-600' : 'text-orange-600' }}">
                        Rp {{ number_format(abs($surplus), 0, ',', '.') }}
                    </div>
                </div>

                <!-- Pembiayaan -->
                <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border-l-4 border-purple-500">
                    <div class="text-slate-500 dark:text-slate-400 text-sm font-medium mb-1">Pembiayaan Netto</div>
                    <div class="text-2xl font-bold text-slate-800 dark:text-white">Rp {{ number_format($totalPembiayaan, 0, ',', '.') }}</div>
                </div>
            </div>

            <!-- Detail Tables Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <!-- Tabel Pendapatan -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-lg border border-slate-100 dark:border-slate-700 overflow-hidden">
                    <div class="p-6 bg-green-50 dark:bg-green-900/20 border-b border-green-100 dark:border-green-900/30 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-800 flex items-center justify-center text-green-600 dark:text-green-300">
                            <i class="fa-solid fa-arrow-down"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-white">Pendapatan Desa</h3>
                    </div>
                    <div class="p-6">
                        @if($pendapatan->count() > 0)
                            <div class="space-y-4">
                                @foreach($pendapatan as $item)
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-50 dark:border-slate-700 last:border-0 last:pb-0">
                                        <div class="font-medium text-slate-700 dark:text-slate-300 mb-1 sm:mb-0">{{ $item->kategori }}</div>
                                        <div class="font-bold text-slate-800 dark:text-white">Rp {{ number_format($item->nominal, 0, ',', '.') }}</div>
                                    </div>
                                @endforeach
                                <div class="pt-4 mt-2 border-t border-slate-100 dark:border-slate-700 flex justify-between items-center text-lg font-bold">
                                    <span class="text-slate-600 dark:text-slate-400">Total</span>
                                    <span class="text-green-600">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-8 text-slate-500">
                                <i class="fa-solid fa-file-invoice text-4xl mb-3 opacity-30"></i>
                                <p>Belum ada data pendapatan.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Tabel Belanja -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-lg border border-slate-100 dark:border-slate-700 overflow-hidden">
                    <div class="p-6 bg-red-50 dark:bg-red-900/20 border-b border-red-100 dark:border-red-900/30 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-800 flex items-center justify-center text-red-600 dark:text-red-300">
                            <i class="fa-solid fa-arrow-up"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-white">Belanja Desa</h3>
                    </div>
                    <div class="p-6">
                        @if($belanja->count() > 0)
                            <div class="space-y-4">
                                @foreach($belanja as $item)
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-50 dark:border-slate-700 last:border-0 last:pb-0">
                                        <div class="font-medium text-slate-700 dark:text-slate-300 mb-1 sm:mb-0">{{ $item->kategori }}</div>
                                        <div class="font-bold text-slate-800 dark:text-white">Rp {{ number_format($item->nominal, 0, ',', '.') }}</div>
                                    </div>
                                @endforeach
                                <div class="pt-4 mt-2 border-t border-slate-100 dark:border-slate-700 flex justify-between items-center text-lg font-bold">
                                    <span class="text-slate-600 dark:text-slate-400">Total</span>
                                    <span class="text-red-600">Rp {{ number_format($totalBelanja, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-8 text-slate-500">
                                <i class="fa-solid fa-file-invoice text-4xl mb-3 opacity-30"></i>
                                <p>Belum ada data belanja.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Tabel Pembiayaan (Full Width if needed, but keeping in grid) -->
                <div class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-3xl shadow-lg border border-slate-100 dark:border-slate-700 overflow-hidden">
                    <div class="p-6 bg-purple-50 dark:bg-purple-900/20 border-b border-purple-100 dark:border-purple-900/30 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-800 flex items-center justify-center text-purple-600 dark:text-purple-300">
                            <i class="fa-solid fa-scale-balanced"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-white">Pembiayaan Desa</h3>
                    </div>
                    <div class="p-6">
                        @if($pembiayaan->count() > 0)
                            <div class="space-y-4">
                                @foreach($pembiayaan as $item)
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-50 dark:border-slate-700 last:border-0 last:pb-0">
                                        <div class="font-medium text-slate-700 dark:text-slate-300 mb-1 sm:mb-0">{{ $item->kategori }}</div>
                                        <div class="font-bold text-slate-800 dark:text-white">Rp {{ number_format($item->nominal, 0, ',', '.') }}</div>
                                    </div>
                                @endforeach
                                <div class="pt-4 mt-2 border-t border-slate-100 dark:border-slate-700 flex justify-between items-center text-lg font-bold">
                                    <span class="text-slate-600 dark:text-slate-400">Total Pembiayaan</span>
                                    <span class="text-purple-600">Rp {{ number_format($totalPembiayaan, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-8 text-slate-500">
                                <i class="fa-solid fa-file-invoice text-4xl mb-3 opacity-30"></i>
                                <p>Belum ada data pembiayaan.</p>
                            </div>
                        @endif
                    </div>
                </div>
                
            </div>
            
            <div class="text-center mt-12">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-primary font-medium hover:underline">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>

        </div>
    </section>
</div>

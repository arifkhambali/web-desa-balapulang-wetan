<x-filament-widgets::widget>
    <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">
                Aksi Cepat
            </h3>
        </div>

        <div class="grid grid-cols-1 gap-4">
            <!-- Buat Surat -->
            <a href="{{ route('filament.admin.pages.buat-surat-warga-page') }}" 
               class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-all border border-transparent hover:border-amber-500 group">
                <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-lg bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 group-hover:scale-110 transition-transform">
                    <x-filament::icon icon="heroicon-o-document-plus" size="5" class="w-5 h-5" />
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">Buat Surat</p>
                    <p class="text-[10px] text-gray-500 dark:text-gray-400 truncate">Layanan surat warga</p>
                </div>
                <x-filament::icon icon="heroicon-m-chevron-right" class="w-4 h-4 text-gray-400 group-hover:text-amber-500 flex-shrink-0" />
            </a>

            <!-- Pending Letters -->
            <a href="{{ route('filament.admin.resources.pengajuan-surats.index', ['tableFilters' => ['status' => ['value' => 'pending']]]) }}" 
               class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-all border border-transparent hover:border-yellow-500 group">
                <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-lg bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400 group-hover:scale-110 transition-transform relative">
                    <x-filament::icon icon="heroicon-o-clock" size="5" class="w-5 h-5" />
                    @php $pendingCount = \App\Models\PengajuanSurat::where('status', 'pending')->count(); @endphp
                    @if($pendingCount > 0)
                        <span class="absolute -top-1 -right-1 flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500 text-[8px] text-white font-bold items-center justify-center">{{ $pendingCount }}</span>
                        </span>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">Cek Pengajuan</p>
                    <p class="text-[10px] text-gray-500 dark:text-gray-400 truncate">Surat butuh verifikasi</p>
                </div>
                <x-filament::icon icon="heroicon-m-chevron-right" class="w-4 h-4 text-gray-400 group-hover:text-yellow-500 flex-shrink-0" />
            </a>

            <!-- Berita Baru -->
            <a href="{{ route('filament.admin.resources.beritas.create') }}" 
               class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-all border border-transparent hover:border-blue-500 group">
                <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 group-hover:scale-110 transition-transform">
                    <x-filament::icon icon="heroicon-o-newspaper" size="5" class="w-5 h-5" />
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">Posting Berita</p>
                    <p class="text-[10px] text-gray-500 dark:text-gray-400 truncate">Update info desa</p>
                </div>
                <x-filament::icon icon="heroicon-m-chevron-right" class="w-4 h-4 text-gray-400 group-hover:text-blue-500 flex-shrink-0" />
            </a>

            <!-- Tambah Warga -->
            <a href="{{ route('filament.admin.resources.penduduks.create') }}" 
               class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-all border border-transparent hover:border-green-500 group">
                <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-lg bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 group-hover:scale-110 transition-transform">
                    <x-filament::icon icon="heroicon-o-user-plus" size="5" class="w-5 h-5" />
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">Input Warga</p>
                    <p class="text-[10px] text-gray-500 dark:text-gray-400 truncate">Tambah data penduduk</p>
                </div>
                <x-filament::icon icon="heroicon-m-chevron-right" class="w-4 h-4 text-gray-400 group-hover:text-green-500 flex-shrink-0" />
            </a>
        </div>
    </div>
</x-filament-widgets::widget>

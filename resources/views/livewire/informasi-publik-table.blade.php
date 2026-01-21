<div>
    <!-- Search & Filters -->
    <div class="mb-8 flex flex-col md:flex-row gap-4 items-center justify-between">
        <div class="relative w-full md:w-96">
            <input type="text" wire:model.live.debounce.300ms="search" 
                placeholder="Cari judul file..." 
                class="w-full pl-12 pr-4 py-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all dark:text-white">
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
            
            <div wire:loading wire:target="search" class="absolute right-4 top-1/2 -translate-y-1/2">
                <i class="fa-solid fa-circle-notch fa-spin text-primary"></i>
            </div>
        </div>
    </div>

    <!-- Documents Table -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-100 dark:border-slate-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-700/50">
                        <th class="px-6 py-4 text-sm font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-sm font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider">Judul File</th>
                        <th class="px-6 py-4 text-sm font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider">Diterbitkan Pada</th>
                        <th class="px-6 py-4 text-sm font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider">Unit Pengelola Informasi</th>
                        <th class="px-6 py-4 text-sm font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse($informasiPublik as $index => $item)
                    <tr class="{{ $index % 2 == 1 ? 'bg-emerald-50/50 dark:bg-emerald-900/10' : 'bg-white dark:bg-slate-800' }} hover:bg-emerald-100/50 dark:hover:bg-emerald-900/20 transition-colors" wire:key="{{ $item->id }}">
                        <td class="px-6 py-4 text-center text-slate-600 dark:text-slate-400">
                            {{ $informasiPublik->firstItem() + $index }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800 dark:text-white">{{ $item->judul }}</div>
                        </td>
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                            {{ $item->tgl_terbit->translatedFormat('d F Y') ?? $item->tgl_terbit->format('d F Y') }}
                        </td>
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                            {{ $item->unit_pengelola }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" 
                                    class="p-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg transition-colors shadow-sm"
                                    title="Lihat File">
                                    <i class="fa-solid fa-eye text-sm"></i>
                                </a>
                                <a href="{{ asset('storage/' . $item->file_path) }}" download="{{ $item->judul }}" 
                                    class="p-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg transition-colors shadow-sm"
                                    title="Download File">
                                    <i class="fa-solid fa-download text-sm"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                            <div class="flex flex-col items-center gap-2">
                                <i class="fa-solid fa-folder-open text-4xl opacity-20"></i>
                                <p>Tidak ada informasi publik yang ditemukan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($informasiPublik->hasPages())
        <div class="px-6 py-4 bg-slate-50 dark:bg-slate-700/30 border-t border-slate-100 dark:border-slate-700 custom-pagination">
            {{ $informasiPublik->links() }}
        </div>
        @endif

        <style>
            .custom-pagination nav > div:last-child {
                @apply flex justify-center !important;
            }
            .custom-pagination nav span[aria-current="page"] > span {
                @apply bg-orange-500 border-orange-500 text-white !important;
            }
            .custom-pagination nav a {
                @apply hover:bg-orange-50 hover:text-orange-600 transition-colors !important;
            }
            .custom-pagination nav span[aria-disabled="true"] > span {
                @apply bg-slate-100 text-slate-400 !important;
            }
        </style>
    </div>
</div>

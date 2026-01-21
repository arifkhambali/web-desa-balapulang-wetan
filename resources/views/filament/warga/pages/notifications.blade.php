<x-filament-panels::page>
    <div class="space-y-4">
        @php
            $notifications = auth()->user()->notifications()->latest()->paginate(20);
        @endphp

        @if($notifications->isEmpty())
            <div class="text-center py-12">
                <div class="flex justify-center mb-4">
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Belum Ada Notifikasi</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Notifikasi akan muncul di sini ketika ada update terkait pengajuan surat Anda.</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach($notifications as $notification)
                    <div class="bg-white dark:bg-gray-800 rounded-lg border {{ $notification->read_at ? 'border-gray-200 dark:border-gray-700' : 'border-green-300 dark:border-green-700 bg-green-50 dark:bg-green-900/10' }} p-4 hover:shadow-md transition-shadow">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                @php
                                    $iconColor = $notification->data['iconColor'] ?? 'gray';
                                    $colorClasses = [
                                        'success' => 'bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400',
                                        'danger' => 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400',
                                        'warning' => 'bg-yellow-100 text-yellow-600 dark:bg-yellow-900/30 dark:text-yellow-400',
                                        'info' => 'bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400',
                                        'primary' => 'bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400',
                                    ];
                                    $bgClass = $colorClasses[$iconColor] ?? $colorClasses['primary'];
                                @endphp
                                <div class="w-10 h-10 rounded-full {{ $bgClass }} flex items-center justify-center">
                                    <x-filament::icon 
                                        :icon="$notification->data['icon'] ?? 'heroicon-o-bell'" 
                                        class="w-5 h-5"
                                    />
                                </div>
                            </div>
                            
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="flex-1">
                                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ $notification->data['title'] ?? 'Notifikasi' }}
                                        </h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                            {{ $notification->data['body'] ?? '' }}
                                        </p>
                                        
                                        @if(isset($notification->data['pengajuan_surat_id']))
                                            <a href="{{ route('filament.warga.resources.pengajuan-surats.view', $notification->data['pengajuan_surat_id']) }}" 
                                               class="inline-flex items-center gap-1 text-xs text-green-600 dark:text-green-400 hover:underline mt-2">
                                                <span>Lihat Detail Surat</span>
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                    
                                    @if(!$notification->read_at)
                                        <span class="flex-shrink-0 inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                            Baru
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="flex items-center gap-4 mt-2">
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                    
                                    @if(!$notification->read_at)
                                        <button 
                                            wire:click="markAsRead('{{ $notification->id }}')"
                                            class="text-xs text-green-600 dark:text-green-400 hover:underline">
                                            Tandai Sudah Dibaca
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</x-filament-panels::page>

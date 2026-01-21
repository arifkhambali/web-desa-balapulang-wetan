<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Aktivitas Terbaru
        </x-slot>

        <x-slot name="description">
            10 aktivitas pengajuan surat terbaru
        </x-slot>

        <div class="space-y-2">
            @forelse($this->getActivities() as $activity)
                <div class="flex items-start gap-3 p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                    <div class="flex-shrink-0 mt-1">
                        <x-filament::icon
                            :icon="$activity['icon']"
                            size="5"
                            class="w-5 h-5 {{ $activity['color'] }}"
                        />
                    </div>
                    <div class="flex-1 min-w-0">
                        <a href="{{ $activity['url'] }}" class="text-sm font-medium text-gray-900 dark:text-white hover:underline">
                            {{ $activity['text'] }}
                        </a>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                            {{ $activity['time'] }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="text-center py-6 text-gray-500 flex flex-col items-center justify-center">
                    <div class="w-8 h-8 mb-2">
                        <x-filament::icon
                            icon="heroicon-o-inbox"
                            size="8"
                            class="w-8 h-8 text-gray-400"
                        />
                    </div>
                    <p class="text-xs">Belum ada aktivitas</p>
                </div>
            @endforelse
        </div>
    </x-filament::section>
</x-filament-widgets::widget>

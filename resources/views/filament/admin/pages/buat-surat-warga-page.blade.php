<x-filament-panels::page>
    <x-filament::section>
        <form wire:submit="submit">
            {{ $this->form }}

            <x-filament::button
                type="submit"
                size="lg"
                color="success"
                icon="heroicon-o-document-arrow-down"
                class="mt-6"
            >
                Buat Surat & Download PDF
            </x-filament::button>
        </form>
    </x-filament::section>

    <x-filament-actions::modals />
</x-filament-panels::page>

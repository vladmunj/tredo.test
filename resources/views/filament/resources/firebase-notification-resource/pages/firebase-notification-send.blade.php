<x-filament-panels::page>
    <form wire:submit.prevent="submit">
        {{ $this->form }}
        <x-filament::button type="submit" size="lg" style="margin: 10px 0">Send notification</x-filament::button>
    </form>
</x-filament-panels::page>

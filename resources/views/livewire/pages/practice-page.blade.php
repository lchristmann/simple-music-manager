<div>
    {{-- Heading --}}
    <flux:heading size="xl" level="1">{{ __('Practice') }}</flux:heading>
    <flux:text class="mb-2 mt-2 text-base">{{ __('Pieces you are currently practicing') }}</flux:text>

    {{-- Pieces List --}}
    <livewire:components.lists.pieces-list :pieces="$practicePieces" :showCollection="false" :showSince="false" />
</div>

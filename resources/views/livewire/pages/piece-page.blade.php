<div>
    <div class="flex items-start justify-between">
        {{-- Heading --}}
        <div>
            <flux:heading size="xl" level="1">
                {{ $piece->name }}
            </flux:heading>
            <flux:text class="mt-2 text-base">
                {{ $piece->artist ?? 'Unknown Artist' }}
            </flux:text>
            @if($piece->arranged_by)
                <flux:text class="mb-6 mt-1 text-base">
                    {{ __('Arr.: ') . $piece->arranged_by }}
                </flux:text>
            @endif
        </div>

        {{-- Edit Button --}}
        <livewire:components.buttons.edit-button
            :link="url('/admin/collections/' . $piece->collection->id . '/pieces/' . $piece->id . '/edit')"
        />
    </div>

    {{-- Content --}}
    <div class="space-y-4">
        {{-- Status --}}
        <livewire:components.badges.playable-status-badge :status="$piece->status"/>
        <livewire:components.badges.difficulty-badge :level="$piece->difficulty" />

        {{-- Sheet Music / Tab --}}
        @if($piece->sheet_music_link)
            <flux:text class="font-medium">
                {{ __('Sheet Music') . ' / ' . __('Tab') . ':' }}
                <flux:link href="{{ $piece->sheet_music_link }}" external>
                    {{ $piece->sheet_music_link }}
                </flux:link>
            </flux:text>
        @endif

        {{-- Lyrics --}}
        @if($piece->lyrics_link)
            <flux:text class="font-medium">
                {{ __('Lyrics') . ':' }}
                <flux:link href="{{ $piece->lyrics_link }}" external>
                    {{ $piece->lyrics_link }}
                </flux:link>
            </flux:text>
        @endif

        {{-- Tutorial --}}
        @if($piece->tutorial_link)
            <flux:text class="font-medium">
                {{ __('Tutorial') . ':' }}
                <flux:link href="{{ $piece->tutorial_link }}" external>
                    {{ $piece->tutorial_link }}
                </flux:link>
            </flux:text>
        @endif

        {{-- Notes --}}
        @if($piece->notes)
            <flux:text class="font-medium">
                {{ __('Notes') }}:
                <flux:text inline variant="strong">
                    {{ $piece->notes }}
                </flux:text>
            </flux:text>
        @endif

        {{-- Collection --}}
        <flux:text class="font-medium">
            {{ __('Collection') }}:
            <flux:link href="{{ route('collections.show', $piece->collection) }}">
                {{ $piece->collection->name }}
            </flux:link>
            <flux:text inline="true" class="text-gray-900 dark:text-gray-100">
                ({{ __($piece->collection->instrument->name) }})
            </flux:text>
        </flux:text>
    </div>
</div>

<ul role="list" class="divide-y divide-gray-200 dark:divide-white/10">
    @forelse($pieces as $piece)
        <li class="py-2" :key="$piece->id">
            <a href="{{ route('pieces.show', $piece) }}"
               class="flex justify-between items-center hover:bg-gray-50 dark:hover:bg-zinc-700 py-2 rounded"
            >
                <div>
                    {{-- Title --}}
                    <div class="font-medium text-gray-900 dark:text-gray-100">
                        {{ $piece->name }}
                    </div>

                    {{-- Artist --}}
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $piece->artist ?? __('Unknown Artist') }}
                    </div>

                    {{-- Collection / Instrument (optional) --}}
                    @if($showCollection)
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $piece->collection->name }} ({{ __($piece->collection->instrument->name) }})
                        </div>
                    @endif

                    {{-- Added X ago (optional) --}}
                    @if($showSince)
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            {{ __('Added') }} {{ $piece->created_at->diffForHumans() }}
                        </div>
                    @endif
                </div>

                <div>
                    <livewire:components.badges.playable-status-badge :status="$piece->status" />
                    <livewire:components.badges.difficulty-badge :level="$piece->difficulty" />
                </div>
            </a>
        </li>
    @empty
        <li class="py-4 text-gray-500 dark:text-gray-400">{{ __('No pieces found.') }}</li>
    @endforelse
</ul>

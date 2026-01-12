<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Simple Music Manager' }}</title>
    @vite('resources/css/app.css')
    @fluxAppearance
</head>
<body class="min-h-screen bg-white dark:bg-zinc-800 antialiased">

    <flux:sidebar sticky collapsible="mobile" class="bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">

        <flux:sidebar.header>
            <flux:sidebar.brand href="#" logo="/logo.svg" logo:dark="/logo-dark.svg" name="{{ __('Simple Music Manager') }}"/>
            <flux:sidebar.collapse class="lg:hidden"/>
        </flux:sidebar.header>

        <flux:sidebar.nav>
            <flux:sidebar.item icon="home" href="{{ route('home') }}">{{ __('Home') }}</flux:sidebar.item>
            <flux:sidebar.item icon="fire" href="{{ route('practice') }}">{{ __('Practice') }}</flux:sidebar.item>
            @foreach(\App\Models\Instrument::with(['collections' => fn ($q) => $q->withCount('pieces'),])->orderBy('sort')->get()
                as $instrument)
                <flux:sidebar.group expandable icon="folder" heading="{{ __($instrument->name) }}" class="grid">
                    @foreach($instrument->collections as $collection)
                        <flux:sidebar.item
                            badge="{{ $collection->pieces_count }}"
                            href="{{ route('collections.show', [$collection->id]) }}">
                            {{ $collection->name }}
                        </flux:sidebar.item>
                    @endforeach
                </flux:sidebar.group>
            @endforeach
            <flux:sidebar.item icon="queue-list" href="{{ route('compilations.index') }}">
                {{ __('Compilations') }}
            </flux:sidebar.item>
        </flux:sidebar.nav>

        <flux:sidebar.spacer/>

        <flux:sidebar.nav>
            <flux:sidebar.item icon="cog-6-tooth" href="/admin">
                {{ __('Manage') }}
            </flux:sidebar.item>
        </flux:sidebar.nav>

        <flux:dropdown position="top" align="start" class="max-lg:hidden">
            <flux:sidebar.profile avatar="/identicon.svg" name="{{ auth()->user()->name }}"/>
            <flux:menu>
                <flux:menu.item icon="arrow-right-start-on-rectangle"
                    wire:click.prevent="document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </flux:menu.item>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>

    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left"/>
        <flux:spacer/>
        <flux:dropdown position="top" alignt="start">
            <flux:profile avatar="/identicon.svg"/>
            <flux:menu>
                <flux:menu.item icon="arrow-right-start-on-rectangle"
                    wire:click.prevent="document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </flux:menu.item>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    <flux:main>
        {{ $slot }}
    </flux:main>

    <form id="logout-form" method="POST" action="{{ route('filament.admin.auth.logout') }}" class="hidden">
        @csrf
    </form>

    @fluxScripts
</body>
</html>

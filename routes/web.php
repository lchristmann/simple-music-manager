<?php

use App\Livewire\Pages\CollectionPage;
use App\Livewire\Pages\CompilationPage;
use App\Livewire\Pages\CompilationsPage;
use App\Livewire\Pages\HomePage;
use App\Livewire\Pages\PiecePage;
use App\Livewire\Pages\PracticePage;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', HomePage::class)
        ->name('home');

    Route::get('/practice', PracticePage::class)
        ->name('practice');

    Route::get('/collections/{collection}', CollectionPage::class)
        ->name('collections.show');

    Route::get('/compilations', CompilationsPage::class)
        ->name('compilations.index');

    Route::get('/compilations/{compilation}', CompilationPage::class)
        ->name('compilations.show');

    Route::get('/pieces/{piece}', PiecePage::class)
        ->name('pieces.show');
});

Route::get('/info', function () {
    Log::info('Phpinfo page visited');
    return phpinfo();
});

Route::get('/health', function () {
    $status = [];

    // Check Database Connection
    try {
        DB::connection()->getPdo();
        // Optionally, run a simple query
        DB::select('SELECT 1');
        $status['database'] = 'OK';
    } catch (\Exception $e) {
        $status['database'] = 'Error';
    }

    // Check Storage Access
    try {
        $testFile = 'health_check.txt';
        Storage::put($testFile, 'OK');
        $content = Storage::get($testFile);
        Storage::delete($testFile);

        if ($content === 'OK') {
            $status['storage'] = 'OK';
        } else {
            $status['storage'] = 'Error';
        }
    } catch (\Exception $e) {
        $status['storage'] = 'Error';
    }

    // Determine overall health status
    $isHealthy = collect($status)->every(function ($value) {
        return $value === 'OK';
    });

    $httpStatus = $isHealthy ? 200 : 503;

    return response()->json($status, $httpStatus);
});

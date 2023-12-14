<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Assets\Js;
use Filament\Support\Assets\Css;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        FilamentAsset::register([
            Js::make('jquery-external-script', 'https://code.jquery.com/jquery-3.7.1.min.js'),            
            Js::make('custom', asset('js/gpt/custom.js')),
            Css::make('local-stylesheet', asset('css/gpt/style.css')),
        ]);          
    }
}

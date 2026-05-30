<?php

namespace App\Providers;

use App\View\Composer\FooterComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Paginator::useBootstrap(); // Sử dụng Bootstrap cho phân trang
        View::composer('client.components.footer', FooterComposer::class);
    }
}

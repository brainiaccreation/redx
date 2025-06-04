<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Doctrine\DBAL\Types\Type;

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
    public function boot()
    {
        View::composer('*', function ($view) {
            $view->with('footerSections', getGroupedFooterLinks());
            $view->with('followUsFooterSections', getFollowUsFooterLinks());
        });

        Blade::directive('hasRoutePermission', function ($routeName) {
            return "<?php if (auth()->check() && auth()->user()->hasPermissionTo(\App\Services\PermissionMap::getPermission($routeName))) : ?>";
        });

        Blade::directive('endhasRoutePermission', function () {
            return "<?php endif; ?>";
        });

        if (!Type::hasType('enum')) {
            Type::addType('enum', \App\Doctrine\EnumType::class);
        }
    }
}

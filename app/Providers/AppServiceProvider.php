<?php

namespace App\Providers;

use View;
use App\View\Components\Farmer;
use App\View\Components\Location;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Monitoring\CIGMemberPonds;
use App\Repositories\Monitoring\CIGMemberLivestock;
use App\Repositories\Monitoring\CIGMemberDetailsInterface;
use App\View\Components\Office;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RepositoryServiceProvider::class);
        $this->registerBindings ();
    }

    public function registerBindings () 
    {
        /* if(auth()->user()->organization_id == config('app.organization_id_dof')) {
            $this->app->bind(CIGMemberDetailsInterface::class, CIGMemberPonds::class);
        } else {
            $this->app->bind(CIGMemberDetailsInterface::class, CIGMemberLivestock::class);
        } */
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::share(
            '_javascript_data',
            array()
        );
        $this->registerComponent();
        Paginator::useBootstrap();
    }

    public function registerComponent()
    {
        Blade::component('package-location', Location::class);
        Blade::component('package-farmer', Farmer::class);
        Blade::component('package-office', Office::class);
    }
}

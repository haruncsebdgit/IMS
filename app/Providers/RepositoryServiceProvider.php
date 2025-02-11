<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Monitoring\AIF\FundAllocation;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\EloquentRepositoryInterface;
use App\Repositories\Monitoring\AIF\ImpactAssessmentInterface;
use App\Repositories\Eloquent\Monitoring\AIF\FundTypeRepository;
use App\Repositories\Monitoring\AIF\FundTypeRepositoryInterface;
use App\Repositories\Monitoring\AIF\AssessmentIndicatorInterface;
use App\Repositories\Monitoring\AIF\IndicatorConfigurationInterface;
use App\Repositories\Eloquent\Monitoring\AIF\FundAllocationRepository;
use App\Repositories\Monitoring\AIF\FundAllocationRepositoryInterface;
use App\Repositories\Eloquent\Monitoring\AIF\FAProjectProgressRepository;
use App\Repositories\Monitoring\AIF\FAProjectProgressRepositoryInterface;
use App\Repositories\Eloquent\Monitoring\AIF\AssessmentIndicatorRepository;
use App\Repositories\Eloquent\Monitoring\AIF\ImpactAssessmentRepository;
use App\Repositories\Eloquent\Monitoring\AIF\IndicatorConfigurationRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(FundTypeRepositoryInterface::class, FundTypeRepository::class);
        $this->app->bind(FundAllocationRepositoryInterface::class, FundAllocationRepository::class);
        $this->app->bind(FAProjectProgressRepositoryInterface::class, FAProjectProgressRepository::class);
        $this->app->bind(AssessmentIndicatorInterface::class, AssessmentIndicatorRepository::class);
        $this->app->bind(IndicatorConfigurationInterface::class, IndicatorConfigurationRepository::class);
        $this->app->bind(ImpactAssessmentInterface::class, ImpactAssessmentRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

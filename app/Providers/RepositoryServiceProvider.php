<?php

namespace App\Providers;

use App\Http\Interfaces\CommentRepositoryInterface;
use App\Http\Interfaces\DiseasesRepositoryInterface;
use App\Http\Interfaces\NotificationRepositoryInterface;
use App\Http\Interfaces\PlantRepositoryInterface;
use App\Http\Interfaces\PlantScheduleRepositoryInterface;
use App\Http\Interfaces\PostRepositoryInterface;
use App\Http\Interfaces\RepositoryInterface;
use App\Http\Interfaces\StageRepositoryInterface;
use App\Http\Interfaces\StepRepositoryInterface;
use App\Repositories\CommentRepo;
use App\Repositories\DiseasesRepo;
use App\Repositories\NotificationRepo;
use App\Repositories\PlantRepo;
use App\Repositories\PlantScheduleRepo;
use App\Repositories\PostRepo;
use App\Repositories\Repository;
use App\Repositories\StageRepo;
use App\Repositories\StepRepo;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(StageRepositoryInterface::class,StageRepo::class);
        $this->app->bind(PlantScheduleRepositoryInterface::class,PlantScheduleRepo::class);
        $this->app->bind(PlantRepositoryInterface::class,PlantRepo::class);
        $this->app->bind(DiseasesRepositoryInterface::class,DiseasesRepo::class);
        $this->app->bind(PostRepositoryInterface::class,PostRepo::class);
        $this->app->bind(CommentRepositoryInterface::class,CommentRepo::class);
        $this->app->bind(RepositoryInterface::class,Repository::class);
        $this->app->bind(StepRepositoryInterface::class,StepRepo::class);
        $this->app->bind(NotificationRepositoryInterface::class,NotificationRepo::class);

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

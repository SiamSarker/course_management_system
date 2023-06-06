<?php

namespace App\Providers;

use App\Repositories\StudentRepository;
use App\Repositories\StudentRepositoryImp;
use App\Services\StudentService;
use App\Services\StudentServiceImp;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(StudentRepository::class, StudentRepositoryImp::class);
        $this->app->bind(StudentService::class, StudentServiceImp::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

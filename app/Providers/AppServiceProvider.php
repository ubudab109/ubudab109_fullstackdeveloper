<?php

namespace App\Providers;

use App\Repositories\UserResume\UserResumeInterface;
use App\Repositories\UserResume\UserResumeRepository;
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
        $this->app->bind(UserResumeInterface::class, UserResumeRepository::class);
    }
}

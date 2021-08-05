<?php

namespace Redbuyers\FollowUpBoss;

use Illuminate\Support\ServiceProvider;

class FollowUpBossServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/followupboss.php',
            'followupboss'
        );
        $this->publishes([
            __DIR__ . '/../config/followupboss.php' => config_path('followupboss.php')
        ]);
    }

    public function register()
    {
        return $this->app->singleton(FollowUpBoss::class, function() {
            return new FollowUpBoss();
        });
    }
}
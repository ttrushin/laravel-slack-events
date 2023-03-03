<?php

namespace Lisennk\LaravelSlackEvents;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application as LaravelApplication;
use Laravel\Lumen\Application as LumenApplication;


/**
 * Class SlackApiServiceProvider
 * @package Lisennk\LaravelSlackEventsApi
 */
class SlackEventsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $source = dirname(__DIR__).'/config/slack-events.php';

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('slack-events.php')], 'slack-events');
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('slack-events');
        }
        $this->mergeConfigFrom($source, 'slack-events');

        require __DIR__.'/Http/routes.php';
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

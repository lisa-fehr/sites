<?php

namespace Warfehr\OmegaOledMsg;

use Illuminate\Support\ServiceProvider;
use Form;
use Event;

class MsgServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/views', 'oled_msg');
        
        // include this macro into your layout
        Form::macro('warfehr_oled_form', function () { 
            return view(
                'oled_msg::form',
                [
                    'rows' => config('config.rows'),
                    'columns' => config('config.columns'),
                    'twitter_handle' => config('config.twitter-handle'),
                ]
            );
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config.php', 'config'
        );
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadMigrationsFrom(__DIR__.'/migrations');

        /*
         * Register the service provider for the dependency.
         */
        $this->app->register('Thujohn\Twitter\TwitterServiceProvider');
        /*
         * Create aliases for the dependency.
         */
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Twitter', 'Thujohn\Twitter\Facades\Twitter');

        Event::listen('WarfehrMsg', 'Warfehr\OmegaOledMsg\Events\MsgHandler@handle');

        $this->app->make('Warfehr\OmegaOledMsg\MsgController');
    }
}

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
        include __DIR__ . '/routes.php';
        $this->loadMigrationsFrom(__DIR__.'/migrations');

        Event::listen('WarfehrMsg', 'Warfehr\OmegaOledMsg\Events\MsgHandler@handle');
        Event::listen('WarfehrImg', 'Warfehr\OmegaOledMsg\Events\ImgHandler@handle');
        Event::listen('WarfehrSocial', 'Warfehr\OmegaOledMsg\Events\SocialHandler@handle');

        $this->app->make('Warfehr\OmegaOledMsg\MsgController');
    }
}

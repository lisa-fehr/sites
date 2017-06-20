<?php

namespace Warfehr\OmegaOledMsg;

use Illuminate\Support\ServiceProvider;
use Form;

class OmegaMsgServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/views', 'omega_oled_msg');
        
        // include this macro into your layout
        Form::macro('warfehr_omega_form', function () { 
            return view(
                'omega_oled_msg::form',
                [
                    'rows' => config('config.rows'),
                    'columns' => config('config.columns')
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
        
        $this->app->make('Warfehr\OmegaOledMsg\OmegaOledMsgController');
    }
}

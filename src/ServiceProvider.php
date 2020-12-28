<?php

namespace Fomvasss\LaravelTranslatable;

use Illuminate\Database\Schema\Blueprint;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/translatable.php' => config_path('translatable.php')
        ], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/translatable.php', 'translatable');

        Blueprint::macro('translatable', function () {
            TranslatableColumns::columns($this);
        });

        Blueprint::macro('dropTranslatable', function () {
            TranslatableColumns::dropColumns($this);
        });

    }
}

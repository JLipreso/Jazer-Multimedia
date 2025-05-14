<?php

namespace Jazer\Multimedia\Http\Provider;

use Illuminate\Support\ServiceProvider;

class MultimediaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../../config/database.php', 'multimedia'  
        );
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../../../config/config.php' => config_path('multimediaconfig.php')
        ], 'multimediaconfig-config');
        
        $this->loadRoutesFrom( __DIR__ . '/../../../routes/api.php');

        config(['database.connections.conn_multimedia' => config('multimedia.database_connection')]);
    }
}

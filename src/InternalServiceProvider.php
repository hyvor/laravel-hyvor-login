<?php

namespace Hyvor\Internal;

use Hyvor\Internal\Laravel\Database\Command\DatabaseNukeCommand;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class InternalServiceProvider extends ServiceProvider
{

    public function boot() : void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

        if (App::environment('testing')) {
            $this->loadRoutesFrom(__DIR__ . '/../routes/testing.php');
        }

        if (file_exists(base_path('InternalFake.php'))) {

        }

        $this->commands([
            DatabaseNukeCommand::class
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'internal');
    }

}

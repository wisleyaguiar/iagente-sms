<?php
/**
 * Created by PhpStorm.
 * User: wisleyaguiar
 * Date: 31/07/18
 * Time: 10:14
 */

namespace IagenteSms\IagenteSms\Providers;

use Illuminate\Support\ServiceProvider;

class IagenteSmsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $configPath = __DIR__ . '/../../config/iagente.php';
        if (function_exists('config_path')) {
            $publishPath = config_path('iagente.php');
        } else {
            $publishPath = base_path('config/iagente.php');
        }
        $this->publishes([$configPath => $publishPath], 'config');
    }

    public function register()
    {
        $configPath = __DIR__ . '/../../config/iagente.php';
        $this->mergeConfigFrom($configPath, 'iagente');

    }
}
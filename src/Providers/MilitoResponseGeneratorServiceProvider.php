<?php
namespace Milito\ResponseGenerator\Providers;

use Illuminate\Support\ServiceProvider;
use Milito\ResponseGenerator\MilitoResponseGenerator;

class MilitoResponseGeneratorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/response.php', "response"
        );
        $this->publishes([
            __DIR__ . '/../../config/response.php' => config_path('response.php'),
        ],"milito-response-config");
    }

    public function register()
    {
        $this->app->bind('militoresponsegenerator',function(){
            return new MilitoResponseGenerator();
        });
    }

}

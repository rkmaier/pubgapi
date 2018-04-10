<?php 

namespace Rkmaier\Pubgapi;

use Illuminate\Support\ServiceProvider;

class PubgApiServiceProvider extends ServiceProvider
{

    /**
     * @var bool
     */
    protected $defer = false;


    public function boot()
    {
        $source = realpath(__DIR__.'/../config/pubgapi.php');
        $this->publishes([$source => config_path('pubgapi.php')]);
    }


    public function register()
    {
        if (file_exists(config_path('pubgapi.php'))) {
            $this->mergeConfigFrom(config_path('pubgapi.php'), 'PubgApi');
        } else {
            $this->mergeConfigFrom(realpath(__DIR__.'/../config/pubgapi.php'), 'PubgApi');
        }

        $this->app->singleton('PubgApi', function ($app) {
            $config = $app->make('config');
            $data['uri'] = $config->get('PubgApi.api_url');
            $data['region'] = $config->get('PubgApi.region');
            $data['access_token'] = $config->get('PubgApi.access_token');
            return new PubgApiService($data);
        });
    }

    /**
     * @return array
     */
    public function provides()
    {
        return array('PubgApi');
    }
}

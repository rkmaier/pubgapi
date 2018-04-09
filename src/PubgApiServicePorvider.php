<?php 

namespace Rkmaier\Pubgapi;

use Illuminate\Support\ServiceProvider;

class PubgApiServiceProvider extends ServiceProvider
{

    /**
     * @var bool
     */
    protected $defer = true;


    public function boot()
    {
        $this->publishes(['
        __DIR__./../config/pubgapi.php'=> config_path('pubgapi.php')]);
    }


    /**CurlService
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/pubgapi.php', 'PubgApi');
        $this->app->bind('PubgApi', function ($app) {
            $config = $app->make('config');
            $data['uri'] = $config->get('PubgApi.api_url');
            $data['shards'] = $config->get('PubgApi.shards');
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

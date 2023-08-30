<?php

namespace App\Providers;

use App\Services\EloquentVimeoContentRepository;
use App\Services\VimeoContentRepository;
use App\Services\VimeoHandler;

use Vimeo\Vimeo;

use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;

class VimeoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->bindVimeoContentRepository();
        $this->bindVimeoHandler();
    }

    private function bindVimeoContentRepository()
    {
        $this->app->bind(VimeoContentRepository::class, EloquentVimeoContentRepository::class);
    }

    private function bindVimeoHandler()
    {
        $this->app->bind(VimeoHandler::class, function (Application $app) {
            $config = $app->make(ConfigRepository::class)->get('vimeo');

            $vimeoClient = new Vimeo($config['client_id'], $config['client_secret'], $config['access_token']);
            
            $contentRepo = $app->make(VimeoContentRepository::class);
            $logger = $app->make(LoggerInterface::class);
            
            return new VimeoHandler($vimeoClient, $contentRepo, $logger);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

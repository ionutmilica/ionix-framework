<?php namespace Ionix\Routing;

use Ionix\Foundation\AbstractServiceProvider;

class RoutingServiceProvider extends AbstractServiceProvider {


    /**
     * Register the dependencies
     *
     * @return mixed
     */
    public function register()
    {
        $this->app['router'] = $this->app->share(function ($app) {
            return new Router(new Dispatcher($app));
        });
    }
}
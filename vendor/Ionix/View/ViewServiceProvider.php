<?php namespace Ionix\View;

use Ionix\Foundation\AbstractServiceProvider;

class ViewServiceProvider extends AbstractServiceProvider {


    /**
     * Register the dependencies
     *
     * @return mixed
     */
    public function register()
    {
        $this->app['view.finder'] = function ($app)
        {
            return new ViewFinder();
        };

        $this->app['view'] = function ($app)
        {
            return new Factory($app['view.finder'], $app['path.root']);
        };
    }
}
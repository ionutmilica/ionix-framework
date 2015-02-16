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
        $this->app['view.finder'] = $this->app->share(function ()
        {
            return new ViewFinder();
        });

        $this->app['view'] = $this->app->share(function ($app)
        {
            return new Factory($app['view.finder'], $app['config']->get('view.paths'));
        });
    }
}
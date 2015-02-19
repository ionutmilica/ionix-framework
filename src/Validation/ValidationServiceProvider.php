<?php namespace Ionix\Validation;

use Ionix\Foundation\AbstractServiceProvider;

class ValidationServiceProvider extends AbstractServiceProvider {

    /**
     * Register the dependencies
     *
     * @return mixed
     */
    public function register()
    {
        $this->app['validation'] = $this->app->share(function () {
            return new Factory(new Parser());
        });

        $this->app->alias('validation', 'Ionix\Validation\Factory');
    }
}
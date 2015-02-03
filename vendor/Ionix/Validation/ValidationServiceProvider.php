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
        $this->app['validation'] = function () {
            return new Factory();
        };
    }
}
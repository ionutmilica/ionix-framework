<?php namespace Ionix\Types;

use Ionix\Foundation\AbstractServiceProvider;

class TypeServiceProvider extends AbstractServiceProvider {

    /**
     * Register the dependencies
     *
     * @return mixed
     */
    public function register()
    {
        require __DIR__.'/helpers.php';
    }
}
<?php namespace Ionix\Foundation;

abstract class AbstractServiceProvider {

    /**
     * @var App
     */
    protected $app;

    /**
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * Register the dependencies
     *
     * @return mixed
     */
    abstract public function register();
}
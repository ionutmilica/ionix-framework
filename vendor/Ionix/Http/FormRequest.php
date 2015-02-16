<?php namespace Ionix\Http;

use Ionix\Foundation\App;

class FormRequest {

    private $validator;

    /**
     * @var Request
     */
    private $request;

    /**
     * @param App $app
     * @param Request $request
     */
    public function __construct(App $app, Request $request)
    {
        $this->validator = $app['validation'];

        $this->request = $request;

        $this->validate();
    }

    private function validate()
    {
        var_dump($this->request);
        //$this->validator->make();
    }
}
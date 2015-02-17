<?php

use Ionix\Http\Request;

class RequestTest extends PHPUnit_Framework_TestCase {


    public function testPathInfo()
    {
        $_SERVER['PATH_INFO'] = '/test';
        $request = Request::createFromGlobals();
        $this->assertEquals('/test', $request->getPathInfo());
    }

    public function testNullPathInfo()
    {
        $_SERVER['PATH_INFO'] = '';
        $_SERVER['REQUEST_URI'] = '/dasdas/tesat/dadas/?do=stuff';
        $_SERVER['QUERY_STRING'] = 'do=stuff';
        $request = Request::createFromGlobals();
        $this->assertEquals('/dasdas/tesat/dadas', $request->getPathInfo());
    }

    public function testRequestMethod()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $request = Request::createFromGlobals();
        $this->assertEquals('POST', $request->getMethod());
    }
}
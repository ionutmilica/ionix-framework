<?php

use Ionix\Routing\Route;

class RouteTest extends PHPUnit_Framework_TestCase {

    protected $routeMatching = [
        ['test', 'test', true],
        ['/test', 'test', true],
        ['test', '/test', true],
        ['test/', 'test/', true],
        ['/test', '/test', true],
        ['/', '', true],
        ['', '/', true],
        ['', '', true],
        ['/', '/', true],
    ];

    public function testRouteMatching()
    {
        foreach ($this->routeMatching as $pair) {
            $this->assertEquals($pair[2], (new Route($pair[0], null))->matches($pair[1]));
        }
    }

    public function testRouteVariableParameter()
    {
        $this->assertTrue((new Route('name/{name}', null))->matches('name/ionut'));
        $this->assertFalse((new Route('test/{age}', null))->where('age', '[0-9]+')->matches('test/ionut'));
    }

    public function testRouteOptionalParameterMatching()
    {
        $this->assertTrue((new Route('name/{name?}', null))->matches('name/ionut'));
        $this->assertTrue((new Route('name/{name?}', null))->matches('name/'));
        $this->assertTrue((new Route('name/{name?}', null))->matches('name'));
        $this->assertTrue((new Route('name/{name?}/{age?}', null))->matches('name/ionut/21'));
        $this->assertTrue((new Route('name/{name?}/{age?}', null))->matches('name'));
    }

    public function testRouteOptionalParameterWithNormalParameter()
    {
        $this->assertTrue((new Route('name/{name?}/{age}', null))->matches('name/ionut/10'));
        $this->assertTrue((new Route('name/{name?}/{age}', null))->matches('name/10'));
        $this->assertTrue((new Route('name/{name}/{age?}', null))->matches('name/ionut'));
        $this->assertTrue((new Route('name/{name?}/{age}', null))->where('name', '[a-z]')
            ->matches('name/10'));
    }

    public function testIfRouteVariableDataIsValid()
    {
        $route = (new Route('name/{name}/{age}', ''));
        $route->matches('/name/ionut/21');
        $this->assertEquals(['name' => 'ionut', 'age' => 21], $route->getData());

        $route = (new Route('name/{name?}/{age}', ''))->where('age', '[0-9]+');
        $route->matches('/name/21');
        $this->assertEquals(['name' => '', 'age' => 21], $route->getData()); // Should consider this
    }

    public function testIfRouteTakesCareOfControllerSintax()
    {
        $route = new Route('test', 'HomeController@index');
        $this->assertEquals(['HomeController', 'index'], $route->getCallback());
        $route = new Route('test', function () {});
        $this->assertInstanceOf('Closure', $route->getCallback());
    }

}
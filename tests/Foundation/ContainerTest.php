<?php

use Ionix\Foundation\Container;

class ContainerTest extends PHPUnit_Framework_TestCase {

    public function testClosureBindingAndFinding() {
        $container = new Container();
        $container->bind('animal', function () {
            return 'cat';
        });
        $this->assertEquals('cat', $container['animal']);
    }

    public function testClosureBindIf()
    {
        $c = new Container();
        $c->bind('test', function () { return 'ionut'; });
        $c->bindIf('test', function () { return 'alex'; });
        $this->assertEquals('ionut', $c->make('test'));
    }

    public function testClosureSharedBinding()
    {
        $container = new Container();
        $obj = new StdClass();
        $closure = function () use ($obj) {
            return $obj;
        };
        $container->bindShared('closure', $closure);
        $this->assertSame($obj, $container['closure']);
    }

    public function testSingletonBinding()
    {
        $container = new Container();
        $obj = new StdClass();
        $closure = function () use ($obj) {
            return $obj;
        };
        $container->singleton('closure', $closure);
        $this->assertSame($obj, $container['closure']);
    }

    public function testInstanceBinding()
    {
        $obj = new StdClass();
        $c = new Container();
        $c->instance('stdclass', $obj);
        $this->assertSame($obj, $c['stdclass']);
    }

    public function testResolveNonClosure()
    {
        $c = new Container();
        $c->bind('IUnitTestSomeRepo', 'UnitTestSomeRepo');
        $this->assertInstanceOf('UnitTestSomeRepo', $c->make('IUnitTestSomeRepo'));
    }

    public function testParametersThroughClosure()
    {
        $c = new Container();
        $c->bind('test', function ($c, $params) { return $params; });
        $this->assertEquals([1, 10], $c->make('test', [1, 10]));
    }

    public function testAliases()
    {
        $c = new Container();
        $c->bind('test', function () { return 10; });
        $c->alias('test', 'test2');
        $this->assertEquals(10, $c->make('test2'));
    }

    public function testShareMethod()
    {
        $container = new Container;
        $closure = $container->share(function() { return new stdClass; });
        $class1 = $closure($container);
        $class2 = $closure($container);
        $this->assertSame($class1, $class2);
    }

    public function testResolveClassWithPrimitivesAndInterfaces()
    {
        $c = new Container();
        $c->bind('IUnitTestSomeRepo', 'UnitTestSomeRepo');
        $class = $c->make('UTestController', [10, 20]);
        $this->assertEquals(10, $class->x);
        $this->assertEquals(20, $class->y);
        $this->assertInstanceOf('UnitTestSomeRepo', $class->repo);
    }
}

/** Classes used for tests */

interface IUnitTestSomeRepo {

}

class UnitTestSomeRepo implements IUnitTestSomeRepo {

}

class UTestController {

    public $x;
    public $repo;
    public $y;

    public function __construct($x, IUnitTestSomeRepo $repo, $y)
    {
        $this->x = $x;
        $this->repo = $repo;
        $this->y = $y;
    }
}

<?php namespace Ionix\Foundation;

use ArrayAccess;
use Closure;
use Exception;
use ReflectionClass;
use ReflectionFunction;
use ReflectionFunctionAbstract;
use ReflectionMethod;

class Container implements ArrayAccess {

    /**
     * Shared objects
     *
     * @var array
     */
    protected $instances = [];

    /**
     * @var array
     */
    protected $bindings = [];

    /**
     * We can alias different dependencies
     *
     * @var array
     */
    protected $aliases = [];

    /**
     * Create alias for an abstract dependency
     *
     * @param $abstract
     * @param $alias
     */
    public function alias($abstract, $alias)
    {
        $this->aliases[$alias] = $abstract;
    }

    /**
     * Bind concrete class to an abstract one
     *
     * @param $abstract
     * @param $concrete
     * @param bool $shared
     */
    public function bind($abstract, $concrete = null, $shared = false)
    {
        if ($concrete == null) {
            $concrete = $abstract;
        }

        if ( ! ($concrete instanceof Closure)) {
            $concrete = function ($container, $args = []) use ($abstract, $concrete) {
                $method = ($abstract == $concrete || is_object($concrete)) ? 'build' : 'make';
                return $container->$method($concrete, $args);
            };
        }

        $this->bindings[$abstract] = [
            'concrete' => $concrete,
            'shared' => $shared
        ];
    }

    /**
     * Bind a shared closure
     *
     * @param $abstract
     * @param callable $closure
     */
    public function bindShared($abstract, Closure $closure)
    {
        $this->bind($abstract, $this->share($closure), true);
    }

    /**
     * Register a binding if it was not registered already
     *
     * @param $abstract
     * @param $concrete
     * @param bool $shared
     */
    public function bindIf($abstract, $concrete, $shared = false)
    {
        if ( ! isset($this->bindings[$abstract]) && ! isset($this->instances[$abstract])) {
            $this->bind($abstract, $concrete, $shared);
        }
    }

    /**
     * Register instance to the container
     *
     * @param $abstract
     * @param $instance
     */
    public function instance($abstract, $instance)
    {
        $this->instances[$abstract] = $instance;
    }

    /**
     * Mark class as singleton
     *
     * @param $abstract
     * @param null $concrete
     */
    public function singleton($abstract, $concrete = null)
    {
        $this->bind($abstract, $concrete, true);
    }

    /**
     * Make closure shared (It will act like singleton)
     *
     * @param callable $closure
     * @return callable
     */
    public function share(Closure $closure)
    {
        return function($container) use ($closure)
        {
            static $object;
            if (is_null($object)) {
                $object = $closure($container);
            }
            return $object;
        };
    }

    /**
     * Create object by the abstract name
     *
     * @param $abstract
     * @param array $args
     * @return mixed
     */
    public function make($abstract, $args = [])
    {
        $abstract = isset($this->aliases[$abstract]) ? $this->aliases[$abstract] : $abstract;

        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        $concrete = isset($this->bindings[$abstract]) ? $this->bindings[$abstract]['concrete'] : $abstract;

        if ($abstract == $concrete || $concrete instanceof Closure) {
            $object = $this->build($concrete, $args);
        } else {
            $object = $this->make($concrete, $args);
        }

        if ($this->isShared($abstract)) {
            $this->instances[$abstract] = $object;
        }

        return $object;
    }

    /**
     * Build concrete class to object
     *
     * @param $concrete
     * @param array $args
     * @return mixed
     * @throws Exception
     */
    public function build($concrete, $args = [])
    {
        if ($concrete instanceof Closure) {
            return $concrete($this, $args);
        }

        $reflectionClass = new ReflectionClass($concrete);

        if ( ! $reflectionClass->isInstantiable()) {
            throw new Exception(sprintf('`s` type is not instantiable !', $concrete));
        }

        $constructor = $reflectionClass->getConstructor();

        if ($constructor === null) {
            return new $concrete();
        }

        $dependencies = $this->getMethodDependencies($constructor, $args);

        return $reflectionClass->newInstanceArgs($dependencies);
    }

    /**
     * Execute method by injecting the dependencies
     *
     * @param $class
     * @param $method
     * @param array $args
     * @return mixed
     * @throws Exception
     */
    public function resolveMethod($class, $method, array $args = [])
    {
        if ( ! is_object($class)) {
            throw new Exception('Container::makeMethod except a object as the first parameter!');
        }

        $reflectionMethod = new ReflectionMethod($class, $method);
        $dependencies = $this->getMethodDependencies($reflectionMethod, $args);

        return $reflectionMethod->invokeArgs($class, $dependencies);
    }

    /**
     * Resolve closure and return its result
     *
     * @param callable $closure
     * @param array $args
     * @return mixed
     */
    public function resolveClosure(Closure $closure, array $args = [])
    {
        $closureRef = new ReflectionFunction($closure);
        $dependencies = $this->getMethodDependencies($closureRef, $args);

        return $closureRef->invokeArgs($dependencies);
    }

    /**
     * Get dependencies for php method
     *
     * @param ReflectionFunctionAbstract $method
     * @param array $primitives
     * @return array
     * @throws Exception
     */
    protected function getMethodDependencies(ReflectionFunctionAbstract $method, array $primitives = [])
    {
        $params = $method->getParameters();

        $resolvedParams = [];
        $i = 0;
        foreach ($params as $param) {
            if ($class = $param->getClass()) {
                $resolvedParams[] = $this->make($class->getName());
            } else if (isset($primitives[$i])) {
                $resolvedParams[] = $primitives[$i++];
            }
        }

        return $resolvedParams;
    }

    /**
     * Check if an abstract class is meant to be shared or not
     *
     * @param $abstract
     * @return bool
     */
    public function isShared($abstract)
    {
        if (isset($this->bindings[$abstract]['shared'])) {
            $shared = $this->bindings[$abstract]['shared'];
        } else {
            $shared = false;
        }
        return isset($this->instances[$abstract]) || $shared === true;
    }

    /**
     *  Clear container bindings
     */
    public function clear()
    {
        $this->instances = [];
        $this->aliases = [];
        $this->bindings = [];
    }

    /**
     * Check if an object exists in the container
     *
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->bindings[$offset]);
    }

    /**
     * Get binding from the container
     *
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->make($offset);
    }

    /**
     * Create a new binding by the $container['key'] method
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        if ( ! $value instanceof Closure) {
            $value = function() use ($value) {
                return $value;
            };
        }
        $this->bind($offset, $value);
    }

    /**
     * Unset binding from the container
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->bindings[$offset], $this->instances[$offset]);
    }

    /**
     * Get dependency from the container
     *
     * @param $offset
     * @return mixed
     */
    public function __get($offset)
    {
        return $this->offsetGet($offset);
    }

    /**
     * Set dependency to the container
     *
     * @param $offset
     * @param $value
     */
    public function __set($offset, $value)
    {
        $this->offsetSet($offset, $value);
    }
}
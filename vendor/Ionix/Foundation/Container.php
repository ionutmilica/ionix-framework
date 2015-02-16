<?php namespace Ionix\Foundation;

use Pimple\Container as PimpleContainer;

class Container extends PimpleContainer
{
    /**
     * Aliases registered for binding the singletons
     *
     * @var array
     */
    protected $aliases = [];

    /**
     * Create alias for a given class registered in the container
     *
     * @param $class
     * @param $alias
     */
    public function alias($class, $alias)
    {
        $this->aliases[$alias] = $class;
    }

    /**
     * Check a class for the alias. If this fails, go back to the old method
     *
     * @param string $id
     * @return mixed
     */
    public function offsetGet($id)
    {
        if (isset($this->aliases[$id]) && $this->offsetExists($this->aliases[$id])) {
            $id = $this->aliases[$id];
        }
        return parent::offsetGet($id);
    }
}
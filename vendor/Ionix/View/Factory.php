<?php namespace Ionix\View;

class Factory {

    /**
     * @var ViewFinder
     */
    private $finder;

    /**
     * @param ViewFinder $finder
     * @param array $paths
     */
    public function __construct(ViewFinder $finder, array $paths = [])
    {
        $this->finder = $finder->addLocation($paths);
    }

    public function make($view, array $data = [])
    {
        return new View($this->finder->find($view), $view, $data);
    }
}
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

    /**
     * Creates a new view object ready to use
     *
     * @param $view
     * @param array $data
     * @return View
     * @throws \Exception
     */
    public function make($view, array $data = [])
    {
        $location = $this->finder->find($view);

        if ( ! $location) {
            throw new \Exception(sprintf('View `%s` cannot be found!', $view));
        }

        return new View($location, $view, $data);
    }
}
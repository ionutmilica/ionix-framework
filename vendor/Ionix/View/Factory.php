<?php namespace Ionix\View;

class Factory {

    protected $configPath;
    /**
     * @var ViewFinder
     */
    private $finder;

    /**
     * @param ViewFinder $finder
     * @param $configPath
     */
    public function __construct(ViewFinder $finder, $configPath)
    {
        $this->configPath = $configPath;
        $this->finder = $finder;

        $this->initFinder();
    }

    protected function initFinder()
    {
        $config = require $this->configPath . '/resources/config/view.php';

        $this->finder->addLocation($config['paths']);
    }

    public function make($view, array $data = [])
    {
        return new View($this->finder->find($view), $view, $data);
    }
}
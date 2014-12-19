<?php namespace Ionix\Foundation;

use Pimple\Container;

class App extends Container {
	
	protected $classes = [];
	protected $directories = [];
	protected $pages;

	/**
	 * Add new directories for auto-loader to search in.
	 *
	 * @param $directories
	 */
	public function addDirectories($directories)
	{
		$this->directories = array_unique(array_merge($this->directories, $directories));
	}

	/**
	 * Register the auto-loader
	 */
	public function init()
	{
		spl_autoload_register(array($this, 'load'));
		$this->registerProviders();
	}

	/**
	 * Set app paths
	 *
	 * @param array $paths
	 */
	public function setPaths(array $paths)
	{
		foreach ($paths as $key => $path) {
			$this[$key] = $path;
		}
	}

	/**
	 * Register all the providers
	 */
	public function registerProviders()
	{
		$appConfig = $this['path.app'] . 'config/app.php';

		$app = require $appConfig;

		foreach ($app['providers'] as $provider) {
			(new $provider($this))->register();
		}
	}

	/**
	 * Search and load a specific class. Used for auto-loader.
	 *
	 * @param $class
	 * @return bool
	 */
	public function load($class)
	{
		if ($class[0] == '\\') $class = substr($class, 1);
		$class = str_replace(array('\\', '_'), DIRECTORY_SEPARATOR, $class).'.php';

		foreach ($this->directories as $directory)
		{
			if (file_exists($path = $directory.DIRECTORY_SEPARATOR.$class))
			{
				require_once $path;
				return true;
			}
		}
		return false;
	}

	/**
	 * Run the application
	 */
	public function run()
	{
		return $this['router']->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
	}
}

<?php namespace Ionix\Foundation;

use Ionix\Http\Request;
use Ionix\Http\Response;
use Pimple\Container;

class App extends Container {

	/**
	 * @var
	 */
	protected static $app;

	public function __construct()
	{
		parent::__construct();

		$this->initDefaultClasses();
	}

	/**
	 * Register the auto-loader
	 */
	public function init()
	{
		self::setApp($this);

		spl_autoload_register(array($this['loader'], 'load'));

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
	 * Run the application
	 */
	public function run()
	{
		$request = Request::createFromGlobals();
		$response = $this['router']->dispatch($request);

		if (true == ($response instanceof Response)) {
			$response->send();
		} else {
			echo $response;
		}
	}

	/**
	 * Store the app instance in a static context
	 *
	 * @param App $app
	 */
	public static function setApp(App $app)
	{
		self::$app= $app;
	}

	/**
	 * Get app instance from the static context
	 *
	 * @return mixed
	 */
	public static function getApp()
	{
		return self::$app;
	}

	/**
	 * Init default classes used by the application
	 */
	private function initDefaultClasses()
	{
		$this['loader'] = function ($app) {
			return new ClassLoader();
		};
	}
}

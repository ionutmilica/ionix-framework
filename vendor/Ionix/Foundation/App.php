<?php namespace Ionix\Foundation;

use Ionix\Http\Request;
use Ionix\Http\Response;
use Pimple\Container;

class App extends Container {

	/**
	 * Framework codename
	 */
	const CODENAME = "IONIX";

	/**
	 * Framework version
	 */
	const VERSION = "Experimental";

	/**
	 * @var
	 */
	protected static $app;

	/**
	 * Store every providers
	 *
	 * @var array
	 */
	protected $providers = [];

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
		self::$app = $this;

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
		$providers = $this['config']->get('app.providers');

		foreach ($providers as $provider) {
			$this->providers[$provider] = new $provider($this);
			$this->providers[$provider]->register();
		}
	}

	/**
	 * Run the application
	 */
	public function run()
	{
		$request = Request::createFromGlobals();

		$this->bootProviders();

		$response = $this['router']->dispatch($request);

		if (false == ($response instanceof Response)) {
			$response = new Response($response);
		}

		$response->send();
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
		$this['config'] = function ($app) {
			$config = new Config();
			$config->addHint($app['path.root'] . '/resources/config/');
			return $config;
		};
	}

	/**
	 * Call providers boot method
	 */
	private function bootProviders()
	{
		foreach ($this->providers as $provider)
		{
			$provider->boot();
		}
	}
}

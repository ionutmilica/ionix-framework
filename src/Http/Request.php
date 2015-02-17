<?php namespace Ionix\Http;

class Request {

    /**
     * @var ParamBag
     */
    public $query;

    /**
     * @var ParamBag
     */
    public $post;

    /**
     * @var ParamBag
     */
    public $cookie;

    /**
     * @var ParamBag
     */
    public $files;

    /**
     * @var ParamBag
     */
    public $server;

    /**
     * @var string
     */
    protected $pathInfo;

    /**
     * @var string
     */
    protected $method;

    /**
     * @param $get
     * @param $post
     * @param $cookie
     * @param $files
     * @param $server
     */
    public function __construct($get, $post, $cookie, $files, $server)
    {
        $this->initialize($get, $post, $cookie, $files, $server);
    }

    /**
     * Prepare the request
     *
     * @param $query
     * @param $post
     * @param $cookie
     * @param $files
     * @param $server
     */
    public function initialize($query, $post, $cookie, $files, $server)
    {
        $this->query = new ParamBag($query);
        $this->post = new ParamBag($post);
        $this->cookie = new ParamBag($cookie);
        $this->files = new ParamBag($files);
        $this->server = new ParamBag($server);

        $this->method = null;
        $this->pathInfo = null;
    }

    /**
     * Create a request object from current globals
     *
     * @return static
     */
    public static function createFromGlobals()
    {
        return new static($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
    }

    /**
     * Get path info
     * Ex: http://localhost/ionix/test => /test
     *     http://localhost/ionix      => /
     */
    public function getPathInfo()
    {
        if ($this->pathInfo == null) {
            if ($this->server->get('PATH_INFO')) {
                $this->pathInfo = $this->server->get('PATH_INFO');
            } else {
                $query = $this->server->get('QUERY_STRING');
                $uri = $this->server->get('REQUEST_URI');
                $this->pathInfo = rtrim(str_replace('?'.$query, '', $uri), '/');
            }
        }
        return $this->pathInfo;
    }

    /**
     * Get method
     */
    public function getMethod()
    {
        if ($this->method == null) {
            $this->method = strtoupper($this->server->get('REQUEST_METHOD', 'GET'));
        }

        return $this->method;
    }
}
<?php namespace Ionix\Http;

class Request {

    private $query;
    private $post;
    private $cookie;
    private $files;
    private $server;

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
}
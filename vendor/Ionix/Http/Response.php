<?php namespace Ionix\Http;

class Response
{

    /**
     * Headers that will be sent via the response
     *
     * @var ParamBag
     */
    protected $headers;

    /**
     * The content that will be echoed
     *
     * @var string
     */
    protected $content;

    /**
     * Page response code
     *
     * @var int
     */
    protected $status;

    /**
     * @param string $content
     * @param int $status
     * @param array $headers
     */
    public function __construct($content = '', $status = 200, $headers = [])
    {
        $this->setContent($content);
        $this->setStatusCode($status);
        $this->headers = new ParamBag($headers);
    }

    /**
     * Set a new conent
     *
     * @param $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Set status code
     *
     * @param $code
     */
    public function setStatusCode($code)
    {
        $this->status = $code;
    }

    /**
     * Send the header to browser
     */
    public function sendHeaders()
    {
        foreach ($this->headers->all() as $header => $value) {
            header(sprintf('%s:%s', $header, $value));
        }
    }

    /**
     * Send the response (headers, status code and content)
     */
    public function send()
    {
        if ( ! headers_sent()) {
            $this->sendHeaders();
        }
        http_response_code($this->status);
        echo $this->content;
    }
}
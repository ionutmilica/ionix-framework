<?php

use Ionix\Http\Response;

class ResponseTest extends PHPUnit_Framework_TestCase {

    public function testResponseContent()
    {
        $response = new Response('Hello world!');
        $this->assertEquals('Hello world!', $response->prepareContent());
    }

    public function testResponseContentWithArray()
    {
        $response = new Response(['users' => ['Ionut', 'Alex', 'Andrei']]);
        $this->assertEquals('{"users":["Ionut","Alex","Andrei"]}', $response->prepareContent());
    }

    public function testResponseContentWithRenderableObjects()
    {
        $response = new Response(new UT_Response_Render());
        $this->assertEquals('Hello!', $response->prepareContent());
    }

    public function testResponseResponseCode()
    {
        (new Response('', 404))->send();
        $this->assertEquals(404, http_response_code());
    }
}

class UT_Response_Render implements \Ionix\Support\Interfaces\Renderable {

    public function render()
    {
        return 'Hello!';
    }
}
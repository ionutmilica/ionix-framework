<?php

use Ionix\Http\ParamBag;

class ParamBagTest extends PHPUnit_Framework_TestCase {

    protected function createBag()
    {
        return new ParamBag([
            'do'   => 'stuff',
            'kill' => 'a dream',
        ]);
    }

    public function testHasParameter()
    {
        $bag = $this->createBag();

        $this->assertTrue($bag->has('do'));
        $this->assertTrue($bag->has('kill'));
    }

    public function testGetParameter()
    {
        $bag = $this->createBag();

        $this->assertEquals('stuff', $bag->get('do'));
        $this->assertEquals('a dream', $bag->get('kill'));
    }

    public function testSetParameter()
    {
        $bag = $this->createBag();
        $bag->set('author', 'ionut');
        $this->assertEquals('ionut', $bag->get('author'));
    }

    public function testAllMethod()
    {
        $bag = $this->createBag();
        $this->assertEquals([
            'do'   => 'stuff',
            'kill' => 'a dream',
        ], $bag->all());
    }

    public function testCountMethod()
    {
        $bag = $this->createBag();
        $this->assertEquals(2, $bag->count());
    }

    public function testCountable()
    {
        $bag = $this->createBag();
        $this->assertEquals(2, count($bag));
    }

    public function assertInputPassByReference()
    {
        $input = [
            'do'   => 'stuff',
            'kill' => 'a dream',
        ];
        $bag = new ParamBag($input);
        $bag->set('kill', 'nothing');
        $this->assertEquals('nothing', $input->kill);
    }
}
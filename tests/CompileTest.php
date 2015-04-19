<?php
namespace Photos;

class CompileTest extends \PHPUnit_Framework_TestCase
{

    public function testSetup()
    {
        $compile = new Compile();
        $this->assertTrue($compile->run());
    }
}

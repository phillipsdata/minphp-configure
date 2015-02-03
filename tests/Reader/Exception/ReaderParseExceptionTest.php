<?php
namespace minphp\Configure\Reader\Exception;

class ReaderParseExceptionTest extends \PHPUnit_Framework_TestCase
{
    
    public function testInstance()
    {
        $this->assertInstanceOf('Exception', new ReaderParseException('test'));
    }
}

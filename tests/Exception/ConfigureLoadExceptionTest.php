<?php
namespace minphp\Configure\Exception;

class ConfigureLoadExceptionTest extends \PHPUnit_Framework_TestCase
{
    
    public function testInstance()
    {
        $this->assertInstanceOf('Exception', new ConfigureLoadException('test'));
    }
}

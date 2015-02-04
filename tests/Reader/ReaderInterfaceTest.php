<?php
namespace minphp\Configure\Reader;

/**
 * @coversDefaultClass \minphp\Configure\Reader\ReaderInterface
 */
class ReaderInterfaceTest extends \PHPUnit_Framework_TestCase implements ReaderInterface
{
    
    public function getIterator()
    {
        return new \ArrayIterator();
    }
    
    /**
     * @covers ::getIterator
     */
    public function testGetIterator()
    {
        $this->assertInstanceOf("\ArrayIterator", $this->getIterator());
    }
}

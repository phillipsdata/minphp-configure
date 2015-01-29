<?php
namespace minphp\Configure\Reader;

/**
 * @coversDefaultClass \minphp\Configure\Reader\ReaderInterface
 */
class ReaderInterfaceTest extends \PHPUnit_Framework_TestCase implements ReaderInterface
{
    
    public function parse(\SplFileObject $file)
    {
        return new \ArrayIterator(array());
    }
    
    /**
     * @covers ::parse
     */
    public function testParse()
    {
        $this->assertInstanceOf("\ArrayIterator", $this->parse(new \SplTempFileObject()));
    }
}

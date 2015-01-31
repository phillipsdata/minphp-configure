<?php
namespace minphp\Configure\Reader;

/**
 * @coversDefaultClass \minphp\Configure\Reader\ReaderFactory
 */
class ReaderFactoryTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->ReaderFactory = new ReaderFactory();
    }
    
    /**
     * @covers ::createReader
     */
    public function testCreateReader()
    {
        $this->assertInstanceOf('\minphp\Configure\PhpReader', $this->ReaderFactory->createReader("php"));
        $this->assertInstanceOf('\minphp\Configure\JsonReader', $this->ReaderFactory->createReader("json"));
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCreateReaderException()
    {
        $this->ReaderFactory->createReader("non-existent-type");
    }
}

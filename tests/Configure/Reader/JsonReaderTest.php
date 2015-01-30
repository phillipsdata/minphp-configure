<?php
namespace minphp\Configure\Reader;

/**
 * @coversDefaultClass \minphp\Configure\Reader\JsonReader
 */
class JsonReaderTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->Reader = new JsonReader();
    }
    
    /**
     * @covers ::parse
     */
    public function testParse()
    {
        $file = $this->getFileMock(json_encode(array('key' => "value")));
        
        $result = $this->Reader->parse($file);
        $this->assertInstanceOf('\ArrayIterator', $result);
        $this->assertEquals("value", $result['key']);
    }
    
    /**
     * @expectedException \minphp\Configure\Reader\Exception\ReaderParseException
     */
    public function testParseException()
    {
        $file = $this->getFileMock("{malformed:}}");
        $this->Reader->parse($file);
    }
    
    protected function getFileMock($data)
    {
        $file = $this->getMockBuilder('\SplFileObject')
            ->setConstructorArgs(array("php://temp"))
            ->setMethods(array('eof', 'fgets'))
            ->getMock();
        
        $file->method('fgets')
            ->will($this->returnValue($data));
            
        $file->method('eof')
            ->will($this->onConsecutiveCalls(false, true));
        
        
        return $file;
    }
}

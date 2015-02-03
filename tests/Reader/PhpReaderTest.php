<?php
namespace minphp\Configure\Reader;

/**
 * @coversDefaultClass \minphp\Configure\Reader\PhpReader
 */
class PhpReaderTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->Reader = new PhpReader();
    }
    
    protected function getFixturePath()
    {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . "Fixtures" . DIRECTORY_SEPARATOR;
    }
    
    /**
     * @covers ::parse
     */
    public function testParse()
    {
        $file = $this->getFileMock($this->getFixturePath() . "Config.php");
        
        $result = $this->Reader->parse($file);
        $this->assertInstanceOf('\ArrayIterator', $result);
        $this->assertEquals("value", $result['key']);
    }
    
    /**
     * @expectedException \minphp\Configure\Reader\Exception\ReaderParseException
     */
    public function testParseException()
    {
        $file = $this->getFileMock(null);
        $result = $this->Reader->parse($file);
    }
    
    protected function getFileMock($filename)
    {
        $file = $this->getMockBuilder('\SplFileObject')
            ->setConstructorArgs(array("php://temp"))
            ->setMethods(array('isFile', 'getPathname'))
            ->getMock();
        
        $file->method('isFile')
            ->will($this->returnValue($filename != null));
        
        $file->method('getPathname')
            ->will($this->returnValue($filename));
        
        
        return $file;
    }
}

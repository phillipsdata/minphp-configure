<?php
namespace minphp\Configure;

/**
 * @coversDefaultClass \minphp\Configure\Configure
 */
class ConfigureTest extends \PHPUnit_Framework_TestCase
{
    
    private $Configure;
    
    public function setUp()
    {
        $this->Configure = new Configure();
    }
    
    /**
     * Load the configuration
     *
     * @param string $file_contents
     * @param \minphp\Configure\Reader\ReaderInterface $reader
     */
    protected function loadConfig($file_contents, $reader)
    {
        $config = new \SplTempFileObject(0);
        $config->fwrite($file_contents);
        $config->rewind();
        
        $this->Configure->load($config, $reader);
    }
    
    /**
     * @covers ::set
     * @covers ::get
     * @dataProvider keyProvider
     */
    public function testSetGet($file_contents, $data)
    {
        $keys = array_keys($data);
        $this->loadConfig($file_contents, $this->getReaderMock($data));
        
        foreach ($keys as $key) {
            $before = $this->Configure->get($key);
            $after = "hello world";
            $this->Configure->set($key, $after);
            $this->assertEquals($after, $this->Configure->get($key));
        }
        
        $this->assertNull($this->Configure->get("key-not-in-the-set"));
    }
    
    /**
     * @covers ::remove
     * @covers ::exists
     * @dataProvider keyProvider
     */
    public function testRemove($file_contents, $data)
    {
        $keys = array_keys($data);
        $this->loadConfig($file_contents, $this->getReaderMock($data));
        
        foreach ($keys as $key) {
            $this->assertTrue($this->Configure->exists($key));
            $this->Configure->remove($key);
            $this->assertFalse($this->Configure->exists($key));
        }
        
        $this->Configure->remove("key-not-in-the-set");
    }
    
    /**
     * Data provider for testFree, testGet, testSet
     *
     * @return array
     */
    public function keyProvider()
    {
        return $this->genericProvider(true);
    }
    
    /**
     * @covers ::load
     * @dataProvider loadProvider
     */
    public function testLoad($file_contents, $data)
    {
        $this->loadConfig($file_contents, $this->getReaderMock($data));
    }
    
    
    /**
     * Data provider for testLoad
     *
     * @return array
     */
    public function loadProvider()
    {
        return $this->genericProvider();
    }
    
    /**
     * Mocks a Reader with the given data
     *
     * @param array $data
     */
    protected function getReaderMock($data)
    {
        $reader = $this->getMockBuilder('\minphp\Configure\Reader\ReaderInterface')
            ->setMethods(array('parse'))
            ->getMock();
            
        $reader->expects($this->once())
            ->method('parse')
            ->will($this->returnValue(new \ArrayIterator($data)));
            
        return $reader;
    }
    
    /**
     * Generic data provider for Configure
     *
     * @param boolean $with_keys
     * @return array
     */
    protected function genericProvider()
    {
        $data = $this->getConfigData();
        
        $params = array(
            array(json_encode($data), $data),
            array("return " . var_export($data, true) . ";", $data)
        );
        
        return $params;
    }
    
    /**
     * Sample config data
     *
     * @return array
     */
    protected function getConfigData()
    {
        return array(
            'key1' => "value1",
            'key2' => true,
            'key3' => array(
                "item1",
                "item2"
            ),
            'key4' => array(
                'subkey1' => 10,
                'subkey2' => null
            )
        );
    }
}

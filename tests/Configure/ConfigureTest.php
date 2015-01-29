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
     * @param string $data
     * @param \minphp\Configure\Reader\ReaderInterface $reader
     */
    private function loadConfig($data, $reader)
    {
        $config = new \SplTempFileObject(0);
        $config->fwrite($data);
        $config->rewind();
        
        $this->Configure->load($config, $reader);
    }
    
    /**
     * @covers ::set
     * @covers ::get
     * @dataProvider keyProvider
     */
    public function testSetGet($data, $reader, $keys)
    {
        $this->loadConfig($data, $reader);
        
        foreach ($keys as $key) {
            $before = $this->Configure->get($key);
            $after = "hello world";
            $this->Configure->set($key, $after);
            $this->assertEquals($after, $this->Configure->get($key));
        }
        
        $this->assertNull($this->Configure->get("key-not-in-the-set"));
    }
    
    /**
     * @covers ::free
     * @covers ::exists
     * @dataProvider keyProvider
     */
    public function testFree($data, $reader, $keys)
    {
        $this->loadConfig($data, $reader);
        
        foreach ($keys as $key) {
            $this->assertTrue($this->Configure->exists($key));
            $this->Configure->free($key);
            $this->assertFalse($this->Configure->exists($key));
        }
        
        $this->Configure->free("key-not-in-the-set");
    }
    
    /**
     * Data provider for testFree, testGet, testSet
     *
     * @return array
     */
    public function keyProvider()
    {
        $data = $this->getConfigData();
        $keys = array_keys($data);
        
        $reader = $this->getMockBuilder('minphp\Configure\Reader\ReaderInterface')
            ->getMock();
        
        return array(
            array(json_encode($data), $reader, $keys),
            array("return " . var_export($data, true) . ";", $reader, $keys)
        );
    }
    
    /**
     * @covers ::load
     * @dataProvider loadProvider
     * @param string $data The data that belongs in the config file
     * @param string $type The type of config file
     */
    public function testLoad($data, $type)
    {
        $this->loadConfig($data, $type);
    }
    
    /**
     * Data provider for testLoad
     *
     * @return array
     */
    public function loadProvider()
    {
        $data = $this->getConfigData();
        
        return array(
            array(json_encode($data), "json"),
            array("return " . var_export($data, true) . ";", "php")
        );
    }
    
    public function testErrorReporting()
    {
        
    }
    
    /**
     * Sample config data
     *
     * @return array
     */
    private function getConfigData()
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

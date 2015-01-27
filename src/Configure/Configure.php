<?php
namespace minphp\Configure;
use minphp\Configure\Reader;
use minphp\Configure\Exception\ConfigureLoadException;

/**
 * Generic configuration library
 */
class Configure
{
    /**
     * @var \ArrayIterator
     */
    protected $data;
    
    public function load(\SplFileObject $file, $type)
    {
        if (!$file->valid()) {
            throw new ConfigureLoadException("Config file not readable.");
        }
        
        switch ($type) {
            case "php":
                $parser = new Reader\PhpReader($file);
                break;
            case "json":
                $parser = new Reader\JsonReader($file);
                break;
            default:
                throw new \InvalidArgumentException("Unrecognized type: " . $type);
        }
        $this->data = $parser->parse($file);
    }
    
    /**
     * Set a value in the config
     *
     * @param mixed $key
     * @param mixed $value
     */
    public function set($key, $value)
    {
        $this->data->offsetSet($key, $value);
    }

    /**
     * Retrieve a value in the config
     *
     * @param mixed $key
     * @return mixed
     */    
    public function get($key)
    {
        $this->data->offsetGet($key);
    }
    
    /**
     * Verify that a key exists
     *
     * @param mixed $key
     * @return boolean
     */  
    public function exists($key)
    {
        return $this->data->offSetExists($key);
    }
    
    /**
     * Removes a value from the config
     *
     * @param mixed $key
     */  
    public function free($key)
    {
        $this->data->offsetUnset($key);
    }
}

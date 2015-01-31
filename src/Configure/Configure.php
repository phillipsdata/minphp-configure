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
    
    /**
     * Loads a config file
     *
     * @param \SplFileObject $file The config file to load
     * @param Reader\ReaderInterface $reader The reader to use, default to auto-detect
     * @throws ConfigureLoadException If the file is not valid
     * @throws \UnexpectedValueException If $reader failed to return the expected type
     */
    public function load(\SplFileObject $file, Reader\ReaderInterface $reader)
    {
        if (!$file->valid()) {
            throw new ConfigureLoadException("Config file not valid.");
        }

        $this->data = $reader->parse($file);
        
        if (!($this->data instanceof \ArrayIterator)) {
            throw new \UnexpectedValueException(get_class($reader) . " returned an unexpected type.");
        }
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
        if ($this->exists($key)) {
            return $this->data->offsetGet($key);
        }
        return null;
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
    public function remove($key)
    {
        if ($this->exists($key)) {
            $this->data->offsetUnset($key);
        }
    }
}

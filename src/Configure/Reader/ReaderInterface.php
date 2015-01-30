<?php
namespace minphp\Configure\Reader;

use minphp\Configure\Reader\Exception\ReaderParseException;

interface ReaderInterface
{

    
    /**
     * Parse the config file
     *
     * @param \SplFileObject $file The configuration file
     * @return \ArrayIterator
     * @throws ReaderParseException When the file can not be parsed
     */
    public function parse(\SplFileObject $file);
}

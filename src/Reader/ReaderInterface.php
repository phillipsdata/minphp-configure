<?php
namespace minphp\Configure\Reader;

use minphp\Configure\Reader\Exception\ReaderParseException;

interface ReaderInterface
{
    
    /**
     * Return the config data as an \ArrayIterator
     *
     * @return \ArrayIterator
     * @throws ReaderParseException When the data can not be parsed
     */
    public function getIterator();
}

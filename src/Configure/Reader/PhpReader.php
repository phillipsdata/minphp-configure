<?php
namespace minphp\Configure\Reader;
use minphp\Configure\Reader\Exception\ReaderParseException;

class PhpReader implements ReaderInterface
{
    /**
     * {@inheritdoc}
     */
    public function parse(\SplFileObject $file)
    {
        if (!$file->isFile()) {
            throw new ReaderParseException("The can not be parsed.");
        }
        return new \ArrayIterator(include_once $file->getPathname());
    }
}

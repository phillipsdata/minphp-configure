<?php
namespace minphp\Configure\Reader;

use minphp\Configure\Reader\Exception\ReaderParseException;

/**
 * PHP Reader
 *
 * Reads PHP config files. Expects files to return an array of key/value pairs.
 */
class PhpReader implements ReaderInterface
{
    /**
     * {@inheritdoc}
     */
    public function parse(\SplFileObject $file)
    {
        if (!$file->isFile()) {
            throw new ReaderParseException("Invalid file.");
        }
        return new \ArrayIterator(include_once $file->getPathname());
    }
}

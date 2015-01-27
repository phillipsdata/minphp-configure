<?php
namespace minphp\Configure\Reader;

class PhpReader implements ReaderInterface
{
    /**
     * {@inheritdoc}
     */
    public function parse(\SplFileObject $file)
    {
        return new \ArrayIterator(include_once $file->getPathname());
    }
}

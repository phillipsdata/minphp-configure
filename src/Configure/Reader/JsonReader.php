<?php
namespace minphp\Configure\Reader;

use minphp\Configure\Reader\Exception\ReaderParseException;

/**
 * JSON Reader
 *
 * Reads JSON config files.
 */
class JsonReader implements ReaderInterface
{
    /**
     * {@inheritdoc}
     */
    public function parse(\SplFileObject $file)
    {
        $data = null;
        while (!$file->eof()) {
            $data .= $file->fgets();
        }

        $data = json_decode($data);

        if (!is_object($data)) {
            throw new ReaderParseException("Unable to parse JSON file.");
        }

        return new \ArrayIterator($data);
    }
}

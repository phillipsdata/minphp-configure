<?php
namespace minphp\Configure\Reader;

/**
 * Reader Factory
 *
 * Creates Readers capable of parsing config files.
 */
class ReaderFactory
{
    /**
     * Factory for generating config readers
     *
     * @param string $type The type of config file
     * @return \minphp\Configure\Reader\ReaderInterface
     * @throws \InvalidArgumentException When given an unrecognized type
     */
    public function createReader($type)
    {
        $reader = null;
        
        switch ($type) {
            case "php":
                $reader = new PhpReader();
                break;
            case "json":
                $reader = new JsonReader();
                break;
            default:
                throw new \InvalidArgumentException("Unrecognized type: " . $type);
        }
        return $reader;
    }
}

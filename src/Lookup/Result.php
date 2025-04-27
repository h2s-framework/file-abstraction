<?php

namespace Siarko\Files\Lookup;

use Siarko\Files\Api\FileInterface;

class Result
{
    public function __construct(
        private readonly string $lookupDirectory,
        private readonly FileInterface $file
    ) {
    }

    /**
     * @return string Base Dir path in which the file lookup was performed
     */
    public function getLookupDirectory(): string
    {
        return $this->lookupDirectory;
    }

    public function getFile(): FileInterface
    {
        return $this->file;
    }

}
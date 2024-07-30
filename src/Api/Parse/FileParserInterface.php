<?php

namespace Siarko\Files\Api\Parse;

use Siarko\Files\Api\FileInterface;

interface FileParserInterface
{


    /**
     * @param FileInterface $file
     * @return mixed
     */
    function parse(FileInterface $file): mixed;
}
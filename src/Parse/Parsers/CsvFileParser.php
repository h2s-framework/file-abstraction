<?php

namespace Siarko\Files\Parse\Parsers;

use Siarko\Files\Api\FileInterface;
use Siarko\Files\Api\Parse\FileParserInterface;

class CsvFileParser implements FileParserInterface
{


    /**
     * @param FileInterface $file
     * @return mixed
     */
    function parse(FileInterface $file): array
    {
        return array_map(function($row){ return str_getcsv($row);}, $file->getContent(true));
    }
}
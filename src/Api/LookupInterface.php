<?php

namespace Siarko\Files\Api;

use Siarko\Files\Lookup\Result;

interface LookupInterface
{

    /**
     * Find files in default workdir
     * @param string $filename
     * @return array<Result>
     */
    public function find(string $filename): array;

}
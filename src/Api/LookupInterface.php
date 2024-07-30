<?php

namespace Siarko\Files\Api;

use Siarko\Paths\Provider\AbstractPathProvider;

interface LookupInterface
{

    /**
     * Find files in default workdir
     * @param string $filename
     * @return array
     */
    public function find(string $filename): array;

}
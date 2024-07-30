<?php

namespace Siarko\Files\Lookup;


use Siarko\Files\Api\LookupInterface;
use Siarko\Files\FileFactory;
use Siarko\Paths\Api\Provider\Pool\PathProviderPoolInterface;

class PoolLookup extends AbstractLookup implements LookupInterface
{

    public function __construct(
        private readonly PathProviderPoolInterface $pathProviderPool,
        private readonly string $fileType,
        FileFactory          $fileFactory
    )
    {
        parent::__construct($fileFactory);
    }

    /**
     * Find files in default workdir
     * @param string $filename
     * @return array
     */
    public function find(string $filename): array
    {
        $result = [];
        foreach($this->pathProviderPool->getProviders($this->fileType) as $provider){
            $result = array_merge($result, $this->findInDir($provider->getConstructedPath(), $filename));
        }
        return $result;
    }


}
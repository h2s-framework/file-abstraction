<?php

namespace Siarko\Files\Lookup;

use Siarko\Files\Api\LookupInterface;
use Siarko\Files\FileFactory;
use Siarko\Paths\Provider\AbstractPathProvider;

class DirectoryLookup extends AbstractLookup implements LookupInterface
{

    /**
     * @param AbstractPathProvider $pathProvider
     * @param FileFactory $fileFactory
     */
    public function __construct(
        private readonly AbstractPathProvider $pathProvider,
        FileFactory                           $fileFactory,
    )
    {
        parent::__construct($fileFactory);
    }

    /**
     * @param string $filename
     * @return array
     */
    public function find(string $filename): array
    {
        return $this->findInDir($this->pathProvider->getConstructedPath(), $filename);
    }

}
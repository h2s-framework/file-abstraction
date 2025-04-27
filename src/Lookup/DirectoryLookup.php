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
     * @param ResultFactory $resultFactory
     */
    public function __construct(
        private readonly AbstractPathProvider $pathProvider,
        FileFactory                           $fileFactory,
        ResultFactory $resultFactory
    )
    {
        parent::__construct($fileFactory, $resultFactory);
    }

    /**
     * @param string $filename
     * @return array<Result>
     */
    public function find(string $filename): array
    {
        return $this->findInDir($this->pathProvider->getConstructedPath(), $filename);
    }

}
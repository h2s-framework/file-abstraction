<?php

namespace Siarko\Files\Lookup;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;
use Siarko\Files\FileFactory;

abstract class AbstractLookup
{
    public function __construct(
        private readonly FileFactory $fileFactory,
        private readonly ResultFactory $resultFactory
    )
    {
    }

    /**
     * @param string $baseDir
     * @param string $filename
     * @return array<Result>
     */
    protected function findInDir(string $baseDir, string $filename): array
    {
        if(!file_exists($baseDir) || !is_dir($baseDir)){
            return [];
        }
        $result = [];
        $Directory = new RecursiveDirectoryIterator($baseDir);
        $Iterator = new RecursiveIteratorIterator($Directory);
        $Regex = new RegexIterator($Iterator, '/.*' . $filename . '$/', RecursiveRegexIterator::GET_MATCH);
        foreach ($Regex as $regex) {
            $file = $this->fileFactory->create();
            $file->setPath($regex[0]);
            $result[] = $this->resultFactory->create([
                'lookupDirectory' => $baseDir,
                'file' => $file,
            ]);
        }
        return $result;
    }

}
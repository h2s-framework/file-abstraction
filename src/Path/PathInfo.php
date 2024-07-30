<?php

namespace Siarko\Files\Path;

use Exception;
use JetBrains\PhpStorm\Pure;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;

class PathInfo
{
    private string $dirname;
    private string $basename;
    private ?string $extension;
    private ?string $filename;

    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        if(!empty($data)){
            $this->dirname = $data['dirname'];
            $this->basename = $data['basename'];
            $this->extension = array_key_exists('extension', $data) ? $data['extension'] : null;
            $this->filename = array_key_exists('filename', $data) ? $data['filename'] : null;
        }
    }

    /**
     * @param string $path
     * @return $this
     */
    public function read(string $path): static
    {
        return new PathInfo(pathinfo($path));
    }

    /**
     * @param string $fileRegex
     * @param bool $recursive
     * @return array
     */
    public function readDirectoryFiles(string $fileRegex = "/^.*$/", bool $recursive = true): array
    {
        $result = [];
        try{
            if(!is_dir($this->getFullPath())){
                return [];
            }
            if($recursive){
                $Directory = new RecursiveDirectoryIterator($this->getFullPath());
                $Iterator = new RecursiveIteratorIterator($Directory);
            }else{
                $Iterator = new \DirectoryIterator($this->getFullPath());
            }
            $Regex = new RegexIterator($Iterator, $fileRegex, RecursiveRegexIterator::MATCH);
            $i = 0;
            foreach ($Regex as $regex) {
                $result[$i++] = $regex->getPathname();
            }
            return $result;
        }catch (Exception) {
            return [];
        }
    }

    /**
     * @return string
     */
    public function getFullPath(): string
    {
        return $this->getDirname().DIRECTORY_SEPARATOR.$this->getBasename();
    }

    /**
     * @return string
     */
    public function getDirname(): string
    {
        return $this->dirname;
    }

    /**
     * @return string
     */
    public function getBasename(): string
    {
        return $this->basename;
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }


}
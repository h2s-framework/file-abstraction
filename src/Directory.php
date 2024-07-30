<?php

namespace Siarko\Files;

use Siarko\Files\Api\DirectoryInterface;
use Siarko\Files\Api\DirectoryInterfaceFactory;
use Siarko\Files\Exception\InvalidDirectoryPath;
use Siarko\Paths\Exception\RootPathNotSet;
use Siarko\Paths\Provider\AbstractPathProvider;
use Siarko\Paths\RootPath;

class Directory implements DirectoryInterface
{
    private string $path;

    /**
     * @param AbstractPathProvider $pathProvider
     * @param RootPath $rootPath
     * @param DirectoryInterfaceFactory $directoryFactory
     * @param bool $projectPath
     * @throws InvalidDirectoryPath
     * @throws RootPathNotSet
     */
    public function __construct(
        AbstractPathProvider $pathProvider,
        RootPath $rootPath,
        private readonly DirectoryInterfaceFactory $directoryFactory,
        bool $projectPath = true
    )
    {
        $this->path = $pathProvider->getConstructedPath();
        if($projectPath && (!str_starts_with($this->path, $rootPath->get()))){
            throw new InvalidDirectoryPath('Directory path is not in project root');
        }
    }

    /**
     * @return void
     */
    public function create(): void
    {
        if(!file_exists($this->path)){
            mkdir($this->path, 0777, true);
        }
    }

    /**
     * @return bool
     */
    public function exists(): bool
    {
        return file_exists($this->path);
    }

    /**
     * @return void
     */
    public function delete(): void
    {
        if($this->exists()){
            rmdir($this->path);
        }
    }

    /**
     * @param string $fileName
     * @return string
     */
    public function getFilePath(string $fileName): string
    {
        return rtrim($this->path, DIRECTORY_SEPARATOR) .
            DIRECTORY_SEPARATOR .
            ltrim($fileName, DIRECTORY_SEPARATOR);
    }


    /**
     * @param string $path
     * @return DirectoryInterface
     */
    public function subdirectory(string $path): DirectoryInterface
    {
        $subDir = clone $this;
        $subDir->path = $this->getFilePath($path);
        return $subDir;
    }
}
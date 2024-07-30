<?php

namespace Siarko\Files\Persistence;

use Siarko\Files\Api\DirectoryInterface;
use Siarko\Files\Api\FileInterface;
use Siarko\Files\Api\Persistence\FilePersistenceInterface;
use Siarko\Files\Exception\FileNotExistsException;
use Siarko\Files\Exception\FilePathNotSetException;

class FilePersistence implements FilePersistenceInterface
{

    /**
     * @param FileInterface $file
     * @return void
     * @throws FilePathNotSetException
     */
    public function create(FileInterface $file): void
    {
        if($file->exists()){
            return;
        }
        fclose(fopen($file->getPath() ?? throw new FilePathNotSetException(), 'w'));
    }

    /**
     * @param FileInterface $file
     * @return void
     * @throws FilePathNotSetException
     */
    public function write(FileInterface $file): void
    {
        $this->create($file);
        file_put_contents($file->getPath(), $file->getContent());
    }

    /**
     * @param FileInterface $file
     * @return void
     */
    public function delete(FileInterface $file): void
    {
        if($file->exists()){
            unlink($file->getPath());
        }
    }

    /**
     * @param FileInterface $file
     * @param DirectoryInterface $directory
     * @return void
     * @throws FileNotExistsException
     */
    public function copy(FileInterface $file, DirectoryInterface $directory): void
    {
        if(!$file->exists()){
            throw new FileNotExistsException($file->getPath());
        }
        $directory->create();
        $filePathInfo = $file->getPathInfo();
        $newPath = $directory->getFilePath($filePathInfo->getBasename());
        if(!file_exists($newPath)){
            copy($filePathInfo->getFullPath(), $directory->getFilePath($filePathInfo->getBasename()));
        }
    }

    /**
     * @param FileInterface $file
     * @param DirectoryInterface $directory
     * @return void
     */
    public function move(FileInterface $file, DirectoryInterface $directory): void
    {
        $filePathInfo = $file->getPathInfo();
        rename($filePathInfo->getFullPath(), $directory->getFilePath($filePathInfo->getBasename()));
    }


    /**
     * @param FileInterface $file
     * @param DirectoryInterface $directory
     * @return void
     * @throws FileNotExistsException
     */
    public function softLink(FileInterface $file, DirectoryInterface $directory): void
    {
        if(!$file->exists()){
            throw new FileNotExistsException($file->getPath());
        }
        $directory->create();
        $filePathInfo = $file->getPathInfo();
        $newPath = $directory->getFilePath($filePathInfo->getBasename());
        if(!file_exists($newPath)){
            symlink($file->getPath(), $directory->getFilePath($file->getPathInfo()->getBasename()));
        }
    }
}
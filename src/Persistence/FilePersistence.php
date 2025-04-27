<?php

namespace Siarko\Files\Persistence;

use Siarko\Files\Api\DirectoryInterface;
use Siarko\Files\Api\FileInterface;
use Siarko\Files\Api\Persistence\FilePersistenceInterface;
use Siarko\Files\Exception\FileCopyException;
use Siarko\Files\Exception\FileNotExistsException;
use Siarko\Files\Exception\FilePathNotSetException;
use Siarko\Files\Exception\FileSoftlinkException;

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
     * @param string|null $content
     * @return void
     * @throws FilePathNotSetException
     */
    public function write(FileInterface $file, ?string $content = null): void
    {
        $this->create($file);
        if($content === null){
            $content = $file->getContent();
        }
        file_put_contents($file->getPath(), $content);
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
     * @throws FileNotExistsException|FileCopyException
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
            if(!@copy($filePathInfo->getFullPath(), $directory->getFilePath($filePathInfo->getBasename()))){
                $lastError = error_get_last();
                error_clear_last(); //clear error to prevent triggering shutdown function
                throw new FileCopyException($file->getPath(), $lastError['message'] ?? '[No error message]');
            }
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
     * @throws FileNotExistsException|FileSoftlinkException
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
            if(!@symlink($file->getPath(), $directory->getFilePath($file->getPathInfo()->getBasename()))) {
                $lastError = error_get_last();
                error_clear_last(); //clear error to prevent triggering shutdown function
                throw new FileSoftlinkException($file->getPath(), $lastError['message'] ?? '[No error message]');
            }
        }
    }
}
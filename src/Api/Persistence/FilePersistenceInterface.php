<?php

namespace Siarko\Files\Api\Persistence;

use Siarko\Files\Api\DirectoryInterface;
use Siarko\Files\Api\FileInterface;

interface FilePersistenceInterface
{

    /**
     * @param FileInterface $file
     * @return void
     */
    public function create(FileInterface $file): void;

    /**
     * @param FileInterface $file
     * @return void
     */
    public function write(FileInterface $file): void;

    /**
     * @param FileInterface $file
     * @return void
     */
    public function delete(FileInterface $file): void;

    /**
     * @param FileInterface $file
     * @param DirectoryInterface $directory
     * @return void
     */
    public function copy(FileInterface $file, DirectoryInterface $directory): void;

    /**
     * @param FileInterface $file
     * @param DirectoryInterface $directory
     * @return void
     */
    public function softLink(FileInterface $file, DirectoryInterface $directory): void;

    /**
     * @param FileInterface $file
     * @param DirectoryInterface $directory
     * @return void
     */
    public function move(FileInterface $file, DirectoryInterface $directory): void;
}
<?php

namespace Siarko\Files\Api;

interface DirectoryInterface
{

    /**
     * @return void
     */
    public function create(): void;

    /**
     * @return bool
     */
    public function exists(): bool;

    /**
     * @return void
     */
    public function delete(): void;

    /**
     * @param string $path
     * @return DirectoryInterface
     */
    public function subdirectory(string $path): DirectoryInterface;

    /**
     * @param string $fileName
     * @return string
     */
    public function getFilePath(string $fileName): string;

}
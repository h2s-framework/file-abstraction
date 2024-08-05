<?php

namespace Siarko\Files\Api;

use Siarko\Files\Path\PathInfo;

interface FileInterface
{

    /**
     * Returns file path
     * @return string|null
     */
    public function getPath(): ?string;

    /**
     * Sets file path
     * @param string $path
     * @return FileInterface
     */
    public function setPath(string $path): FileInterface;

    /**
     * Returns true if file exists
     * @return bool
     */
    public function exists(): bool;

    /**
     * Returns file content as string or array of rows
     * @param bool $asArray
     * @return string|array
     */
    public function getContent(bool $asArray = false): string|array;

    /**
     * Sets file content
     * @param string $content
     * @return void
     */
    public function setContent(string $content): void;

    /**
     * Return path info object
     * @return PathInfo|null
     */
    public function getPathInfo(): ?PathInfo;

    /**
     * @return array
     */
    public function getMimeTypes(): array;

}
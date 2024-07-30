<?php

namespace Siarko\Files;

use Siarko\Files\Api\FileInterface;
use Siarko\Files\Path\PathInfo;
use Siarko\Files\Path\PathInfoFactory;
use Siarko\Serialization\Api\Attribute\Serializable;
use Symfony\Component\Mime\MimeTypes;
use Symfony\Component\Mime\MimeTypesInterface;

class File implements FileInterface
{

    #[Serializable]
    private ?string $path = null;

    /**
     * @param PathInfoFactory $pathInfoFactory
     * @param MimeTypes $mimeTypes
     */
    public function __construct(
        private readonly PathInfoFactory $pathInfoFactory,
        private readonly MimeTypes       $mimeTypes
    )
    {
    }

    /**
     * @param string $path
     * @return $this
     */
    public function setPath(string $path): File
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * @return bool
     */
    public function isPathSet(): bool
    {
        return $this->path !== null;
    }

    /**
     * @return bool
     */
    public function exists(): bool
    {
        if ($this->isPathSet()) {
            return file_exists($this->path);
        }
        return false;
    }

    /**
     * @param bool $asArray return file contents as array of rows
     * @return string|string[]
     */
    public function getContent(bool $asArray = false): string|array
    {
        if ($this->exists()) {
            if ($asArray) {
                return file($this->getPath());
            } else {
                return file_get_contents($this->getPath());
            }
        }
        return '';
    }

    /**
     * @return PathInfo|null
     */
    public function getPathInfo(): ?PathInfo
    {
        if ($this->exists()) {
            return $this->pathInfoFactory->create()->read($this->getPath());
        }
        return null;
    }

    /**
     * @return array
     */
    public function getMimeTypes(): array
    {
        $mimes = $this->mimeTypes->getMimeTypes($this->getPathInfo()->getExtension());
        if (!empty($mimes)) {
            return $mimes;
        }
        return [$this->mimeTypes->guessMimeType($this->getPath())];
    }
}
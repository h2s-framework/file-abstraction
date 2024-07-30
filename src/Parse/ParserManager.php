<?php

namespace Siarko\Files\Parse;

use Siarko\Files\Api\FileInterface;
use Siarko\Files\Api\Parse\FileParserInterface;
use Siarko\Files\Exception\FileParserNotFoundException;
use Symfony\Component\Mime\MimeTypes;

class ParserManager
{

    public const KEY_MIME_TYPES = 'mimeTypes';
    public const KEY_PARSER = 'parser';

    /**
     * @param MimeTypes $mimeTypes
     * @param array $parsers
     */
    public function __construct(
        private readonly MimeTypes $mimeTypes,
        private readonly array $parsers = []
    )
    {
    }

    /**
     * @param string $id
     * @return array|null
     */
    public function getParsersByType(string $id): ?array
    {
        return $this->parsers[$id] ?? null;
    }

    /**
     * @param string $id
     * @param FileInterface $file
     * @return FileParserInterface|null
     */
    public function findParser(string $id, FileInterface $file): ?FileParserInterface
    {
        $parsers = $this->getParsersByType($id);
        if(!empty($parsers)){
            $pathInfo = $file->getPathInfo();
            $mimeTypes = $this->mimeTypes->getMimeTypes($pathInfo->getExtension());
            if(empty($mimeTypes)){
                return $this->findParserByMimeType($parsers, $this->mimeTypes->guessMimeType($file->getPath()));
            }
            foreach ($mimeTypes as $mimeType) {
                $parser = $this->findParserByMimeType($parsers, $mimeType);
                if($parser){
                    return $parser;
                }
            }
        }
        return null;
    }

    /**
     * @param array $parsers
     * @param string $mimeType
     * @return FileParserInterface|null
     */
    protected function findParserByMimeType(array $parsers, string $mimeType): ?FileParserInterface
    {
        foreach ($parsers as $parser){
            if(in_array($mimeType, $parser[self::KEY_MIME_TYPES])){
                return $parser[self::KEY_PARSER];
            }
        }
        return null;
    }

    /**
     * @param FileInterface $file
     * @param string $type
     * @return mixed
     * @throws FileParserNotFoundException
     */
    public function parse(FileInterface $file, string $type): mixed
    {
        $parser = $this->findParser($type, $file);
        if($parser){
            return $parser->parse($file);
        }
        throw new FileParserNotFoundException($type);
    }
}
<?php

namespace Siarko\Files\Api\Persistence;

use Siarko\Files\Api\DirectoryInterface;

interface DirectoryPersistenceInterface
{

    public function create(DirectoryInterface $directory): void;

    public function delete(DirectoryInterface $directory): void;
}
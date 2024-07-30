<?php

namespace Siarko\Files;

class FileFactory extends \Siarko\Api\Factory\AbstractFactory
{

	public function create(array $data = []): File
	{
		return parent::_create(File::class, $data);
	}
}

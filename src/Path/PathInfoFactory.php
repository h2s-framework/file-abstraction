<?php

namespace Siarko\Files\Path;

class PathInfoFactory implements \Siarko\Api\Factory\FactoryInterface
{
	public function create(array $data = []): \Siarko\Files\Path\PathInfo
	{
		return new PathInfo($data);
	}
}

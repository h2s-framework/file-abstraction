<?php

namespace Siarko\Files\Lookup;

use Siarko\Api\Factory\AbstractFactory;

class ResultFactory extends AbstractFactory
{

    /**
     * @param array $data
     * @return Result
     */
    public function create(array $data = []): Result
    {
        return $this->_create(Result::class, $data);
    }

}
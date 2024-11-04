<?php

namespace Siarko\Files\Exception;

use JetBrains\PhpStorm\Pure;
use Throwable;

class FileSoftlinkException extends \Exception
{
    /**
     * Construct the exception. Note: The message is NOT binary safe.
     * @link https://php.net/manual/en/exception.construct.php
     * @param string $file
     * @param int $code [optional] The Exception code.
     * @param null|Throwable $previous [optional] The previous throwable used for the exception chaining.
     */
    #[Pure] public function __construct(string $file = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('Could not create softlink for file '.$file, $code, $previous);
    }


}
<?php

namespace Siarko\Files\Exception;

use JetBrains\PhpStorm\Pure;
use Throwable;

class FileCopyException extends \Exception
{

    /**
     * Construct the exception. Note: The message is NOT binary safe.
     * @link https://php.net/manual/en/exception.construct.php
     * @param string $file
     * @param string $sysMessage
     * @param int $code [optional] The Exception code.
     * @param null|Throwable $previous [optional] The previous throwable used for the exception chaining.
     */
    #[Pure] public function __construct(string $file = "", string $sysMessage = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('Could not copy file '.$file.", Reason: ".$sysMessage, $code, $previous);
    }
}
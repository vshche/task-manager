<?php

declare(strict_types=1);

namespace TaskManager\Domain\Exception;

use Exception;

final class DateTimeException extends Exception
{
    /**
     * @param Exception $e
     */
    public function __construct(Exception $e)
    {
        parent::__construct('Datetime Malformed or not valid', $e->getCode(), $e);
    }
}

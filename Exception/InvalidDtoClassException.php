<?php

declare(strict_types=1);

namespace Wakeapp\Component\DtoResolver\Exception;

use RuntimeException;

class InvalidDtoClassException extends RuntimeException
{
    /**
     * @param string $className
     */
    public function __construct(string $incorrectClassName, string $className)
    {
        $this->message = sprintf(
            'Incorrect DTO class. Received class "%s" should implements "%s"',
            $incorrectClassName,
            $className
        );
    }
}

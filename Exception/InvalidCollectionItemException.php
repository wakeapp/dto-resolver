<?php

declare(strict_types=1);

namespace Wakeapp\Component\DtoResolver\Exception;

use RuntimeException;

class InvalidCollectionItemException extends RuntimeException
{
    /**
     * @param string $className
     */
    public function __construct(string $className)
    {
        $this->message = sprintf('Incorrect collection item. Item should implements "%s"', $className);
    }
}

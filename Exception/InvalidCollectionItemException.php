<?php

declare(strict_types=1);

namespace Wakeapp\Component\DtoResolver\Exception;

use RuntimeException;
use function sprintf;

class InvalidCollectionItemException extends RuntimeException
{
    /**
     * @param string $className
     */
    public function __construct(string $className)
    {
        parent::__construct(sprintf('Incorrect collection item. Item should implements "%s"', $className));
    }
}

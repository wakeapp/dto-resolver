<?php

declare(strict_types=1);

namespace Wakeapp\Component\DtoResolver\Exception;

use RuntimeException;
use function sprintf;

class FieldForIndexNotFoundException extends RuntimeException
{
    /**
     * @param string $field
     */
    public function __construct(string $field)
    {
        parent::__construct(sprintf('Field "%s" for indexing not found in the received collection item', $field));
    }
}

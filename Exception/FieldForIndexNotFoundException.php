<?php

declare(strict_types=1);

/*
 * This file is part of the DtoResolver package.
 *
 * (c) Wakeapp <https://wakeapp.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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

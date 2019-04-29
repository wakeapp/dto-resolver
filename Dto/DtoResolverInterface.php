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

namespace Wakeapp\Component\DtoResolver\Dto;

use JsonSerializable;

interface DtoResolverInterface extends JsonSerializable
{
    /**
     * Returns DTO properties as array
     *
     * @param bool $onlyDefinedData
     *
     * @return array
     */
    public function toArray(bool $onlyDefinedData = true): array;
}

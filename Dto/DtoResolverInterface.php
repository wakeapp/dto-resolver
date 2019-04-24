<?php

declare(strict_types=1);

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

<?php

declare(strict_types=1);

namespace Wakeapp\Component\DtoResolver\Dto;

use Iterator;
use Wakeapp\Component\DtoResolver\Exception\InvalidCollectionItemException;
use JsonSerializable;

interface CollectionDtoResolverInterface extends Iterator, JsonSerializable
{
    /**
     * Add item to the collection
     *
     * @param array $item
     *
     * @throws InvalidCollectionItemException When received unsupported collection item
     */
    public function add(array $item): void;

    /**
     * Returns name of the supported collection {@see DtoResolverInterface}
     *
     * @return string
     */
    public static function getItemDtoClassName(): string;

    /**
     * @param bool $onlyDefinedData
     *
     * @return array
     */
    public function toArray(bool $onlyDefinedData = true): array;
}

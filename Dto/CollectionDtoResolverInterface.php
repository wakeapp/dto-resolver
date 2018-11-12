<?php

declare(strict_types=1);

namespace Wakeapp\Component\DtoResolver\Dto;

use Iterator;
use Wakeapp\Component\DtoResolver\Exception\InvalidCollectionItemException;

interface CollectionDtoResolverInterface extends DtoResolverInterface, Iterator
{
    /**
     * Add item to the collection
     *
     * @param array $item
     *
     * @throws InvalidCollectionItemException When received unsupported collection item
     */
    public function add(array $item);

    /**
     * Returns name of the supported entry dto
     * @see DtoResolverInterface
     *
     * @return string
     */
    public function getEntryDtoClassName(): string;

    /**
     * {@inheritdoc}
     *
     * @return array[]
     */
    public function toArray(bool $onlyDefinedData = true): array;
}

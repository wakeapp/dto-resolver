<?php

declare(strict_types=1);

namespace Wakeapp\Component\DtoResolver\Dto;

use Wakeapp\Component\DtoResolver\Exception\InvalidCollectionItemException;
use Iterator;

abstract class AbstractCollectionDtoResolver
    extends AbstractDtoResolver
    implements CollectionDtoResolverInterface, Iterator
{
    /**
     * @var DtoResolverInterface[]
     */
    private $collection = [];

    /**
     * {@inheritdoc}
     */
    public function add(array $item): self
    {
        $className = $this->getEntryDtoClassName();

        $entryDto = new $className();

        if (!$entryDto instanceof DtoResolverInterface) {
            throw new InvalidCollectionItemException(DtoResolverInterface::class);
        }

        $resolver = $this->getOptionsResolver();

        if ($resolver) {
            $entryDto->injectResolver($resolver);
        }

        $entryDto->resolve($item);

        $id = spl_object_hash($entryDto);

        $this->collection[$id] = $entryDto;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function getEntryDtoClassName(): string;

    /**
     * {@inheritdoc}
     *
     * @return array[]
     */
    public function toArray(bool $onlyDefinedData = true): array
    {
        $result = [];

        foreach ($this->collection as $item) {
            $result[] = $item->toArray($onlyDefinedData);
        }

        return $result;
    }

    /**
     * @return mixed
     */
    public function next()
    {
        next($this->collection);

        return $this->key();
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return $this->collection[$this->key()];
    }

    /**
     * @return mixed
     */
    public function rewind()
    {
        return reset($this->collection);
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return key($this->collection);
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return isset($this->collection[$this->key()]);
    }
}

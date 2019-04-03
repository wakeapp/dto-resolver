<?php

declare(strict_types=1);

namespace Wakeapp\Component\DtoResolver\Dto;

use Wakeapp\Component\DtoResolver\Exception\InvalidCollectionItemException;

trait CollectionDtoResolverTrait
{
    use DtoResolverTrait;

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
     * {@inheritdoc}
     */
    public function next()
    {
        next($this->collection);
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->collection[$this->key()];
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        reset($this->collection);
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return key($this->collection);
    }

    /**
     * {@inheritdoc}
     */
    public function valid(): bool
    {
        return isset($this->collection[$this->key()]);
    }
}

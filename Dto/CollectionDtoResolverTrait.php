<?php

declare(strict_types=1);

namespace Wakeapp\Component\DtoResolver\Dto;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Wakeapp\Component\DtoResolver\Exception\InvalidCollectionItemException;

trait CollectionDtoResolverTrait
{
    /**
     * @var OptionsResolver
     */
    private $optionsResolver;

    /**
     * @var DtoResolverInterface[]
     */
    private $collection = [];

    /**
     * @param array $item
     */
    public function add(array $item): void
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
    }

    /**
     * @return string
     */
    abstract public function getEntryDtoClassName(): string;

    /**
     * @param bool $onlyDefinedData
     *
     * @return array
     */
    public function toArray(bool $onlyDefinedData = true): array
    {
        $result = [];

        foreach ($this->collection as $item) {
            $result[] = $item->toArray($onlyDefinedData);
        }

        return $result;
    }

    public function next()
    {
        next($this->collection);
    }

    /**
     * @return DtoResolverInterface
     */
    public function current()
    {
        return $this->collection[$this->key()];
    }

    public function rewind()
    {
        reset($this->collection);
    }

    /**
     * @return int|string|null
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

    /**
     * @param OptionsResolver $resolver
     */
    public function injectResolver(OptionsResolver $resolver): void
    {
        $this->optionsResolver = $resolver;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * @return OptionsResolver
     */
    protected function getOptionsResolver(): OptionsResolver
    {
        return $this->optionsResolver;
    }
}

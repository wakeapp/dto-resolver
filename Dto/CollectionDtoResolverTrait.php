<?php

declare(strict_types=1);

namespace Wakeapp\Component\DtoResolver\Dto;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Wakeapp\Component\DtoResolver\Exception\InvalidCollectionItemException;
use function is_subclass_of;
use function key;
use function next;
use function reset;
use function spl_object_hash;

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
     * @param OptionsResolver|null $resolver
     */
    public function __construct(?OptionsResolver $resolver = null)
    {
        $this->optionsResolver = $resolver;
    }

    /**
     * @param array $item
     */
    public function add(array $item): void
    {
        $className = $this->getEntryDtoClassName();

        if (is_subclass_of($className, DtoResolverInterface::class)) {
            throw new InvalidCollectionItemException(DtoResolverInterface::class);
        }

        $entryDto = new $className($item, $this->optionsResolver);
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
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}

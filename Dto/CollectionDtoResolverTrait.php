<?php

declare(strict_types=1);

namespace Wakeapp\Component\DtoResolver\Dto;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Wakeapp\Component\DtoResolver\Exception\FieldForIndexNotFoundException;
use Wakeapp\Component\DtoResolver\Exception\InvalidCollectionItemException;
use function is_subclass_of;
use function key;
use function next;
use function reset;

trait CollectionDtoResolverTrait
{
    /**
     * @var DtoResolverInterface[]
     */
    private $collection = [];

    /**
     * @var string|null
     */
    private $indexBy = null;

    /**
     * @var OptionsResolver
     */
    private $optionsResolver;

    /**
     * @param OptionsResolver|null $resolver
     * @param string|null $indexBy
     */
    public function __construct(?OptionsResolver $resolver = null, ?string $indexBy = null)
    {
        $this->optionsResolver = $resolver;
        $this->indexBy = $indexBy;

        $className = self::getItemDtoClassName();

        if (!is_subclass_of($className, DtoResolverInterface::class)) {
            throw new InvalidCollectionItemException(DtoResolverInterface::class);
        }
    }

    /**
     * Returns name of the supported collection {@see DtoResolverInterface}
     *
     * @return string
     */
    abstract public static function getItemDtoClassName(): string;

    /**
     * @param array $item
     */
    public function add(array $item): void
    {
        $className = self::getItemDtoClassName();
        $entryDto = new $className($item, $this->optionsResolver);

        if ($this->indexBy === null) {
            $this->collection[] = $entryDto;

            return;
        }

        if (!isset($item[$this->indexBy])) {
            throw new FieldForIndexNotFoundException($this->indexBy);
        }

        $id = $item[$this->indexBy];
        $this->collection[$id] = $entryDto;
    }

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

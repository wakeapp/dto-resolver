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

use Symfony\Component\OptionsResolver\OptionsResolver;
use Wakeapp\Component\DtoResolver\Exception\FieldForIndexNotFoundException;
use Wakeapp\Component\DtoResolver\Exception\InvalidCollectionItemException;
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
     * @var OptionsResolver
     */
    private $optionsResolver;

    /**
     * @var string|null
     */
    private $indexBy;

    /**
     * @var string|null
     */
    private $className;

    /**
     * @param OptionsResolver|null $resolver
     * @param string|null $indexBy
     */
    public function __construct(?OptionsResolver $resolver = null, ?string $indexBy = null)
    {
        $this->optionsResolver = $resolver;
        $this->indexBy = $indexBy;

        $this->className = self::getItemDtoClassName();

        if (!is_subclass_of($this->className, DtoResolverInterface::class)) {
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
        $collectionItem = new $this->className($item, $this->optionsResolver);

        if ($this->indexBy === null) {
            $this->collection[] = $collectionItem;

            return;
        }

        $key = $item[$this->indexBy] ?? null;

        if (null === $key) {
            throw new FieldForIndexNotFoundException($this->indexBy);
        }

        $this->collection[$key] = $collectionItem;
    }

    /**
     * @param bool $onlyDefinedData
     *
     * @return array
     */
    public function toArray(bool $onlyDefinedData = true): array
    {
        $result = [];

        foreach ($this->collection as $key => $item) {
            $result[$key] = $item->toArray($onlyDefinedData);
        }

        return $result;
    }

    public function next(): void
    {
        next($this->collection);
    }

    /**
     * @return DtoResolverInterface
     */
    public function current(): DtoResolverInterface
    {
        return $this->collection[$this->key()];
    }

    public function rewind(): void
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

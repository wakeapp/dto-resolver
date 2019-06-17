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

use function property_exists;

trait DtoArrayAccessTrait
{
    /**
     * {@inheritdoc}
     */
    public function offsetExists($propertyName): bool
    {
        return property_exists($this, $propertyName);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($propertyName)
    {
        return $this->$propertyName;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($propertyName, $value): void
    {
        $this->$propertyName = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($propertyName): void
    {
        $this->$propertyName = null;
    }

    /**
     * {@inheritdoc}
     */
    public function __get($propertyName)
    {
        return $this->offsetGet($propertyName);
    }

    /**
     * {@inheritdoc}
     */
    public function __isset($propertyName): bool
    {
        return $this->offsetExists($propertyName);
    }
}

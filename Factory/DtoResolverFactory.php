<?php

declare(strict_types=1);

namespace Wakeapp\Component\DtoResolver\Factory;

use Wakeapp\Component\DtoResolver\Dto\CollectionDtoResolverInterface;
use Wakeapp\Component\DtoResolver\Dto\DtoResolverInterface;
use Wakeapp\Component\DtoResolver\Exception\InvalidDtoClassException;

class DtoResolverFactory
{
    /**
     * @param string $className
     * @param array $data
     *
     * @return DtoResolverInterface
     */
    public function createDto(string $className, array $data): DtoResolverInterface
    {
        if (!is_subclass_of($className, DtoResolverInterface::class)) {
            throw new InvalidDtoClassException($className, DtoResolverInterface::class);
        }

        /** @var DtoResolverInterface $resultDto */
        $resultDto = new $className();
        $resultDto->resolve($data);

        return $resultDto;
    }
}

<?php

declare(strict_types=1);

namespace Wakeapp\Component\DtoResolver\Tests\Mock;

use Wakeapp\Component\DtoResolver\Dto\CollectionDtoResolverInterface;
use Wakeapp\Component\DtoResolver\Dto\CollectionDtoResolverTrait;

class CollectionDtoClass implements CollectionDtoResolverInterface
{
    use CollectionDtoResolverTrait;

    public static function getItemDtoClassName(): string
    {
        return DtoClass::class;
    }
}

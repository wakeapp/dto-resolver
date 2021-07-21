<?php

declare(strict_types=1);

namespace Wakeapp\Component\DtoResolver\Tests\Dto;

use PHPUnit\Framework\TestCase;
use Wakeapp\Component\DtoResolver\Tests\Mock\CollectionDtoClass;
use Wakeapp\Component\DtoResolver\Tests\Mock\DtoClass;

class CollectionDtoResolverTraitTest extends TestCase
{
    public function testAdd(): void
    {
        $collectionDto = new CollectionDtoClass();

        $collectionDto->add([
            'publicProperty' => 'testPublic',
            'protectedProperty' => 'testProtected',
            'privateProperty' => 'testPrivate',
        ]);

        /** @var DtoClass $item */
        $item = $collectionDto->current();

        $this->assertCount(1, $collectionDto);
        $this->assertInstanceOf(DtoClass::class, $item);
        $this->assertSame('testPrivate', $item->getPrivateProperty());
        $this->assertSame('testProtected', $item->getProtectedProperty());
        $this->assertSame('testPublic', $item->getPublicProperty());
    }

    public function testToArray(): void
    {
        $collectionDto = new CollectionDtoClass();

        $data = [
            'publicProperty' => 'testPublic',
            'protectedProperty' => 'testProtected',
            'privateProperty' => 'testPrivate',
        ];

        $collectionDto->add($data);

        $this->assertSame($collectionDto->toArray(), [$data]);
    }
}

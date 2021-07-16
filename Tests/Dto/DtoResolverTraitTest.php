<?php

declare(strict_types=1);

namespace Wakeapp\Component\DtoResolver\Tests\Dto;

use PHPUnit\Framework\TestCase;
use Symfony\Component\OptionsResolver\Exception\ExceptionInterface;
use Wakeapp\Component\DtoResolver\Tests\Mock\DtoClass;

class DtoResolverTraitTest extends TestCase
{
    /**
     * @throws ExceptionInterface
     */
    public function testConstructor(): void
    {
        $dto = new DtoClass([
            'publicProperty' => 'testPublic',
            'protectedProperty' => 'testProtected',
            'privateProperty' => 'testPrivate',
        ]);

        $this->assertSame('testPrivate', $dto->getPrivateProperty());
        $this->assertSame('testProtected', $dto->getProtectedProperty());
        $this->assertSame('testPublic', $dto->getPublicProperty());
    }

    /**
     * @throws ExceptionInterface
     */
    public function testToArray(): void
    {
        $data = [
            'publicProperty' => 'testPublic',
            'protectedProperty' => 'testProtected',
            'privateProperty' => 'testPrivate',
            'unknownProperty' => 'testUnknown',
        ];

        $dto = new DtoClass($data);
        unset($data['unknownProperty']);

        $this->assertSame($dto->toArray(), $data);
    }

    /**
     * @throws ExceptionInterface
     */
    public function testGetDefinedProperties(): void
    {
        $expectedPropertyList = ['publicProperty', 'protectedProperty', 'privateProperty'];

        $dto = new DtoClass([]);

        $this->assertSame(array_combine($expectedPropertyList, $expectedPropertyList), $dto->getDefinedProperties());
    }
}

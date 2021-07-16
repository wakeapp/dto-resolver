<?php

declare(strict_types=1);

namespace Wakeapp\Component\DtoResolver\Tests\Dto\php74;

use PHPUnit\Framework\TestCase;
use Symfony\Component\OptionsResolver\Exception\ExceptionInterface;
use Wakeapp\Component\DtoResolver\Tests\Mock\TypedPropertyDtoClass;

use function array_combine;

class DtoResolverTraitTest extends TestCase
{
    /**
     * @throws ExceptionInterface
     */
    public function testConstructor(): void
    {
        $dto = new TypedPropertyDtoClass([
            'publicProperty' => 'testPublic',
            'protectedProperty' => 'testProtected',
            'privateProperty' => 'testPrivate',
            'publicTypedProperty' => 'testPublicTypedProperty',
            'protectedTypedProperty' => 'testProtectedTypedProperty',
            'privateTypedProperty' => 'testPrivateTypedProperty',
        ]);

        $this->assertSame('testPrivate', $dto->getPrivateProperty());
        $this->assertSame('testProtected', $dto->getProtectedProperty());
        $this->assertSame('testPublic', $dto->getPublicProperty());
        $this->assertSame('testPublicTypedProperty', $dto->getPublicTypedProperty());
        $this->assertSame('testProtectedTypedProperty', $dto->getProtectedTypedProperty());
        $this->assertSame('testPrivateTypedProperty', $dto->getPrivateTypedProperty());
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
            'publicTypedProperty' => 'testPublicTypedProperty',
            'protectedTypedProperty' => 'testProtectedTypedProperty',
            'privateTypedProperty' => 'testPrivateTypedProperty',
        ];

        $dto = new TypedPropertyDtoClass($data);
        unset($data['unknownProperty']);

        $this->assertSame($dto->toArray(), $data);
    }

    /**
     * @throws ExceptionInterface
     */
    public function testGetDefinedProperties(): void
    {
        $expectedPropertyList = [
            'publicProperty',
            'protectedProperty',
            'privateProperty',
            'publicTypedProperty',
            'protectedTypedProperty',
            'privateTypedProperty',
        ];

        $dto = new TypedPropertyDtoClass([]);

        $this->assertSame(array_combine($expectedPropertyList, $expectedPropertyList), $dto->getDefinedProperties());
    }
}

<?php

declare(strict_types=1);

namespace Wakeapp\Component\DtoResolver\Tests\Dto;

use PHPUnit\Framework\TestCase;
use Symfony\Component\OptionsResolver\Exception\ExceptionInterface;
use Wakeapp\Component\DtoResolver\Tests\Mock\DtoClass;

use function array_column;

class DtoArrayAccessTraitTest extends TestCase
{
    /**
     * @throws ExceptionInterface
     */
    public function testOffsetExist(): void
    {
        $dto = new DtoClass([
            'publicProperty' => 'testPublic',
            'protectedProperty' => 'testProtected',
            'privateProperty' => 'testPrivate',
            'unknownProperty' => 'testUnknown',
        ]);

        $this->assertTrue($dto->offsetExists('publicProperty'));
        $this->assertTrue($dto->offsetExists('protectedProperty'));
        $this->assertTrue($dto->offsetExists('privateProperty'));
        $this->assertFalse($dto->offsetExists('unknownProperty'));
    }

    /**
     * @throws ExceptionInterface
     */
    public function testOffsetGet(): void
    {
        $dto = new DtoClass([
            'publicProperty' => 'testPublic',
            'protectedProperty' => 'testProtected',
            'privateProperty' => 'testPrivate',
        ]);

        $this->assertSame('testPublic', $dto->offsetGet('publicProperty'));
        $this->assertSame('testProtected', $dto->offsetGet('protectedProperty'));
        $this->assertSame('testPrivate', $dto->offsetGet('privateProperty'));
    }

    /**
     * @throws ExceptionInterface
     */
    public function testOffsetSet(): void
    {
        $dto = new DtoClass([
            'publicProperty' => 'testPublic',
            'protectedProperty' => 'testProtected',
            'privateProperty' => 'testPrivate',
        ]);

        $dto->offsetSet('publicProperty', 'updatedPublic');
        $dto->offsetSet('protectedProperty', 'updatedProtected');
        $dto->offsetSet('privateProperty', 'updatedPrivate');

        $this->assertSame('updatedPublic', $dto->offsetGet('publicProperty'));
        $this->assertSame('updatedProtected', $dto->offsetGet('protectedProperty'));
        $this->assertSame('updatedPrivate', $dto->offsetGet('privateProperty'));
    }

    /**
     * @throws ExceptionInterface
     */
    public function testArrayAccess(): void
    {
        $data = [
            'publicProperty' => 'testPublic',
            'protectedProperty' => 'testProtected',
            'privateProperty' => 'testPrivate',
        ];

        $dto = new DtoClass($data);

        $this->assertSame('testPublic', $dto['publicProperty']);
        $this->assertSame('testProtected', $dto['protectedProperty']);
        $this->assertSame('testPrivate', $dto['privateProperty']);
    }

    /**
     * @throws ExceptionInterface
     */
    public function testOffsetUnset(): void
    {
        $dto = new DtoClass([
            'publicProperty' => 'testPublic',
            'protectedProperty' => 'testProtected',
            'privateProperty' => 'testPrivate',
        ]);

        $dto->offsetUnset('publicProperty');
        $dto->offsetUnset('protectedProperty');
        $dto->offsetUnset('privateProperty');

        $this->assertNull($dto->offsetGet('publicProperty'));
        $this->assertNull($dto->offsetGet('protectedProperty'));
        $this->assertNull($dto->offsetGet('privateProperty'));
    }

    /**
     * @throws ExceptionInterface
     */
    public function testArrayColumn(): void
    {
        $dto = new DtoClass([
            'publicProperty' => 'testPublic',
            'protectedProperty' => 'testProtected',
            'privateProperty' => 'testPrivate',
        ]);

        $this->assertSame(['testPublic'], array_column([$dto], 'publicProperty'));
        $this->assertSame(['testProtected'], array_column([$dto], 'protectedProperty'));
        $this->assertSame(['testPrivate'], array_column([$dto], 'privateProperty'));
    }
}
